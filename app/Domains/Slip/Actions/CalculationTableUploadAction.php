<?php

	namespace App\Domains\Slip\Actions;

	use App\Domains\Businesse\Models\Businesse;
	use App\Enums\TypeCession;
	use App\Models\ActivityRate;
	use App\Models\Pays;
	use App\Models\Pool;
	use App\Models\Reinsurer;
	use App\Models\Slip;
	use App\Models\Transferor;
	use App\Models\Treaty;
	use Illuminate\Database\Eloquent\Builder;
	use Nette\Utils\Type;

	final class CalculationTableUploadAction
	{
		public array $datas = [];
		public array $percent = [];
		public array $percentFact = [];
		public array $percentReinsurer = [];
		public array $restePool = [];
		public array $CapAndPrime = [];
		public float|null $total_prime = null;

		public function __invoke(Slip $slip): array
		{
			$businesses = ($slip->load('business'))->business()->get();
			foreach ($businesses as $key => $businesse) {
				//if ($key < 1) continue;

				//Obtenir Le pays et trouver les cessions légales
				$pays = Pays::query()->where('label', '=', $businesse->pays_assure);
				$this->insertCalcultionData($pays, TypeCession::CLF->value, $businesse, $key);

				//calcul de la conservation cédante avec la valeur de la consevation cedante de l'affaire
				$this->conservationTransferor($businesse, $key);

				//calcul de la fact
				$this->insertCalcultionData($pays, TypeCession::CF->value, $businesse, $key);

				//Calcul du reste pool Pvt
				$this->cessionPool($businesse, $key, $pays);
				//dd($this->CapAndPrime[$key + 1]['total_capacity']);
				if (isset($this->CapAndPrime[$key + 1]['total_capacity']) && ($this->restePool[$key + 1] * $businesse->capitaux / 100) > $this->CapAndPrime[$key + 1]['total_capacity']) {
					$this->cessionFacultative($businesse, $key);
				}

				//calcul des reversement
				$this->reversementReinsurer($businesse, $key, $pays);
				$this->revertToIndividualReas($businesse, $pays, $key);
			}
			$this->datas['total_prime'] = $this->total_prime;

			//dd($this->restePool);
			//dd($this->datas);
			return $this->datas;
		}

		private function insertCalcultionData(Builder $pays, string $typeCession, Businesse $businesse, int $keyBusinesse): void
		{
			$percent = 0;
			$er = 0;
			$getCessionFranc = $pays->withWhereHas('legal_transferts', fn($query) => $query->where('type', $typeCession))->first();

			//verification si c'est une cession legale au premier Franc
			if ($getCessionFranc && $typeCession === TypeCession::CLF->value) {
				foreach ($getCessionFranc->getAttribute('legal_transferts') as $cession) {

					$this->datas[$typeCession][$cession->getAttribute('reinsurer')['raison_social']][$keyBusinesse + 1] =
						[
							'affaire' => $keyBusinesse + 1,
							'price' => (float)$cession->getAttribute('pivot')['price'],
							'capital' => $cession->getAttribute('pivot')['price'] * $businesse->capitaux / 100,
							'prime' => $cession->getAttribute('pivot')['price'] * $businesse->prime / 100,
						];
					$percent += (float)$cession->getAttribute('pivot')['price'];
				}

				$this->percent[$keyBusinesse + 1] = $percent;


			} //verification si c'est une cession legale Fact
			else if ($getCessionFranc) {
				$percentFact = 0;
				foreach ($getCessionFranc->getAttribute('legal_transferts') as $cession) {

					//conservation dynamique à changer
					$this->datas[$typeCession][$cession->getAttribute('reinsurer')['raison_social']][$keyBusinesse + 1] =
						[
							'name' => $keyBusinesse + 1,
							'price' => (float)($cession->getAttribute('pivot')['price'] * (100 - $this->percent[$keyBusinesse + 1])) / 100,
							'capital' => ($cession->getAttribute('pivot')['price'] * ($this->percent[$keyBusinesse + 1]) / 100) * $businesse->capitaux / 100,
							'prime' => ($cession->getAttribute('pivot')['price'] * ($this->percent[$keyBusinesse + 1]) / 100) * $businesse->prime / 100,
						];

					//dd($this->datas);
					$percentFact += ($cession->getAttribute('pivot')['price'] * (100 - $this->percent[$keyBusinesse + 1])) / 100;

				}
				//enregistrement du Pourcentage Fact et Pourcentage en Pool
				$this->percentFact[$keyBusinesse + 1] = $percentFact;
				$this->restePool[$keyBusinesse + 1] = 100 - ($this->percent[$keyBusinesse + 1] + ($this->percentFact[$keyBusinesse + 1]));


			}


		}

		private function conservationTransferor(Businesse $businesse, int $keyBusinesse): void
		{

			$this->datas['Conservation_cedante'][$keyBusinesse + 1][] =
				[
					'price' => $businesse->commission_cedante,
					'capital' => $businesse->commission_cedante * $businesse->capitaux / 100,
					'prime' => $businesse->commission_cedante * $businesse->prime / 100,
				];

			$this->percent[$keyBusinesse + 1] += $businesse->commission_cedante;


		}

		private function cessionPool(Businesse $businesse, int $keyBusinesse, Builder $pays): void
		{
			$taux_transferor = null;
			$reasPoolPrice = Pool::query()->where('year',
				(new \DateTime($businesse->date_reception))->format('Y'))
				->withWhereHas('reinsurers', static function ($query) {
					$query->where([
						'poolable_type' => Reinsurer::class,
					]);
				})->first();
			$getAct = ActivityRate::find($businesse->activity_rate_id);
			//dd($businesse->activity_rate_id);
			//dd($getAct->activity);
			$getTrueId = ActivityRate::where([
				'pays_id' => ($pays->first())->id,
				'activity_ratable_type' => Reinsurer::class,
				'activity' => $getAct->activity,
				'type' => $getAct->type,
			])->first();
			/*dd($getTrueId);
			dd($businesse->activity_rate_id);*/
			$poolWithTransferor = Pool::query()
				->where('year',
					(new \DateTime($businesse->date_reception))->format('Y'))
				->withWhereHas('transferors', static function ($query) use ($businesse, $getTrueId) {
					$query->where([
						'poolable_id' => $businesse->transferor_id,
						'activity_rates_id' => $getTrueId->id
					]);

				})->first()?->toArray();
			//dd((float)$poolWithTransferor['transferors'][0]['pivot']['taux_validate'], $getTrueId->id);
			if ($poolWithTransferor) {
				$taux_transferor = (float)$poolWithTransferor['transferors'][0]['pivot']['taux_validate'];
			} else {
				$taux_transferor = 0.72;
			}

			$getTreaty = Treaty::query()->where([
				'year' => (new \DateTime($businesse->date_reception))->format('Y'),
				//'pays_id' => ($pays->first())->id
			])->withWhereHas('reinsurers')->first();
			$prime = null;
			$capital = null;
			//dd($getTreaty);
			if ($getTreaty) {
				$this->CapAndPrime[$keyBusinesse + 1]['total_capacity'] = $getTreaty->total_capicity;
				$this->CapAndPrime[$keyBusinesse + 1]['capital'] =
					($this->restePool[$keyBusinesse + 1] * $businesse->capitaux / 100) > $getTreaty->total_capicity
						? $getTreaty->total_capicity : ($this->restePool[$keyBusinesse + 1] * $businesse->capitaux / 100);

				$this->CapAndPrime[$keyBusinesse + 1]['prime'] =
					($this->restePool[$keyBusinesse + 1] * $businesse->capitaux / 100) > $getTreaty->total_capicity
						? $getTreaty->total_capicity
						: ($this->restePool[$keyBusinesse + 1] * $businesse->capitaux / 100);
			} else {
				$this->CapAndPrime[$keyBusinesse + 1]['capital'] = ($this->restePool[$keyBusinesse + 1] * $businesse->capitaux / 100);
				$this->CapAndPrime[$keyBusinesse + 1]['prime'] = ($this->restePool[$keyBusinesse + 1] * $businesse->capitaux / 100);
			}

			if (isset($this->restePool[$keyBusinesse + 1])) {

				$this->datas['cession_pool'][$keyBusinesse + 1][] =
					[

						//'price' =>100 - (($cession->getAttribute('pivot')['price'] * (100 - $this->percent[$keyBusinesse + 1])) / 100),
						'price' => $this->restePool[$keyBusinesse + 1],
						'capital' => $this->CapAndPrime[$keyBusinesse + 1]['capital'],
						/*'prime' => $this->restePool[$keyBusinesse + 1] * $businesse->prime / 100,*/

						'prime' => $this->CapAndPrime[$keyBusinesse + 1]['prime'] * $taux_transferor / 100,

					];
			}


		}

		private function cessionFacultative(Businesse $businesse, int $keyBusinesse): void
		{

			$this->datas['cession_facultative'][$keyBusinesse + 1][] =
				[
					//'price' =>100 - (($cession->getAttribute('pivot')['price'] * (100 - $this->percent[$keyBusinesse + 1])) / 100),
					'price' => 100 - $this->restePool[$keyBusinesse + 1],
					'capital' => ($this->restePool[$keyBusinesse + 1] * $businesse->capitaux / 100) - $this->CapAndPrime[$keyBusinesse + 1]['total_capacity'],
					'prime' => $this->restePool[$keyBusinesse + 1] * $businesse->prime / 100,
				];
		}

		private function reversementReinsurer(Businesse $businesse, int $keyBusinesse, Builder $pays): void
		{
			$taux_transferor = null;
			$this->percentReinsurer[$keyBusinesse + 1] = 100 - ($this->restePool[$keyBusinesse + 1] + $this->percentFact[$keyBusinesse + 1]);
			$businessActivityPrice = $businesse->load('activity_rate')->activity_rate->price;
			$getAct = ActivityRate::find($businesse->activity_rate_id);


			//Obtenion du taux reas en fonction de l'activity de l'affaire
			$getTrueId = ActivityRate::where([
				'pays_id' => ($pays->first())->id,
				'activity_ratable_type' => Reinsurer::class,
				'activity' => $getAct->activity,
				'type' => $getAct->type,
			])->first();

			//requete pour recuperer la convention avec les reassurerur en fonction
			$reasPoolPrice = Pool::query()->where([
				'year' => (new \DateTime($businesse->date_reception))->format('Y'),
				'pays_id' => ($pays->first())->id,

			])->withWhereHas('reinsurers', static function ($query) use ($getTrueId) {
				$query->where([
					'poolable_type' => Reinsurer::class,
					'activity_rates_id' => $getTrueId->id
				]);
			})->first();

			//dd($reasPoolPrice->reinsurers->first()->pivot->taux_validate);
			$poolWithTransferor = Pool::query()
				->where('year',
					(new \DateTime($businesse->date_reception))->format('Y'))
				->withWhereHas('transferors', static function ($query) use ($businesse, $getTrueId) {
					$query->where([
						'poolable_id' => $businesse->transferor_id,
						'activity_rates_id' => $getTrueId->id
					]);

				})->first()?->toArray();
			//dd($getTrueId->id);
			if ($poolWithTransferor) {
				$taux_transferor = (float)$poolWithTransferor['transferors'][0]['pivot']['taux_validate'];
			}


			//dd($reasPoolPrice->getAttribute('taux'));
			if (!$reasPoolPrice) {
				if ($getTrueId->price !== null) {
					$taux = $getTrueId->price;
				} else {
					$taux = 0.25;
				}
			} else {
				$taux = (float)$reasPoolPrice->reinsurers->first()->pivot->taux_validate;
				//dd($taux);
			}
			//dd($reasPoolPrice->reinsurers->where());

			$this->datas['reversement_reinsurer'][$keyBusinesse + 1][] =
				[
					'price' => $this->restePool[$keyBusinesse + 1],
					'capital' => $this->CapAndPrime[$keyBusinesse + 1]['capital'],
					'prime' => $this->CapAndPrime[$keyBusinesse + 1]['prime'] * (float)$taux / 100,

				];
			$this->total_prime += ($this->restePool[$keyBusinesse + 1] * $businesse->capitaux / 100) > 4300000000 ? 4300000000 * (float)$taux / 100 :
				($this->restePool[$keyBusinesse + 1] * $businesse->capitaux / 100) * (float)$taux / 100;


		}

		private function revertToIndividualReas(Businesse $businesse, Builder $pays, int $keyBusinesse): void
		{
			$reas = Treaty::query()
				->where(
					[
						'year' => now()->format('Y'),
						'pays_id' => ($pays->first())->id
					]
				)->with('reinsurers')->first();
			//dd($reas);

			if ($reas !== null) {
				//dd($this->datas['reversement_reinsurer'][$keyBusinesse + 1]);
				foreach ($reas->reinsurers as $re) {
					if (isset($this->datas['reassureurs'][$re->raison_social]['prime'])) {
						$this->datas['reassureurs'][$re->raison_social] = [
							'prime' => $this->datas['reassureurs'][$re->raison_social]['prime'] + ($re->pivot->part * $this->datas['reversement_reinsurer'][$keyBusinesse + 1][0]['prime'])
						];

					} else {
						$this->datas['reassureurs'][$re->raison_social] = [
							'prime' => ($re->pivot->part * $this->datas['reversement_reinsurer'][$keyBusinesse + 1][0]['prime'])
						];
					}
					//dd($this->datas['reassureurs']);


				}
			} else {
				/*$this->datas['reassureurs'] = array_merge
				($this->datas['reassureurs'],
					[
						'AFRICA Re' => [
							'engagement' => 2500000000,
							'part' => 55.56,
						],
						'AVENI Re' => [
							'engagement' => 200000000,
							'part' => 4.44,
						],
						'CONTINENTAL Re' => [
							'engagement' => 250000000,
							'part' => 5.56,
						],
						'GHANA Re' => [
							'engagement' => 220000000,
							'part' => 4.89,
						],
						'KENYA Re' => [
							'engagement' => 300000000,
							'part' => 6.67,
						],
						'NCA Re' => [
							'engagement' => 200000000,
							'part' => 4.44,
						],
						'SEN Re' => [
							'engagement' => 430000000,
							'part' => 9.55,
						],
						'WAICA Re' => [
							'engagement' => 400000000,
							'part' => 8.89,
						],
					]
				);*/
				//throw new \Exception('merci de créer un traité avec le Pays : ' . ($pays->first())->label, 303);
				abort(200, 'merci de créer un traité avec le Pays : ' . ($pays->first())->label);
			}

		}
	}