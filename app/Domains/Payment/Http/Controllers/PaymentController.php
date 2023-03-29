<?php

	namespace App\Domains\Payment\Http\Controllers;

	use App\Domains\Businesse\Models\Businesse;
	use App\Domains\Helpers\GroupHelpers;
	use App\Domains\Payment\Models\Payment;
	use App\Http\Controllers\Controller;
	use App\Models\Reinsurer;
	use Illuminate\Http\RedirectResponse;
	use Illuminate\Http\Request;

	class PaymentController extends Controller
	{

		final public function store(Request $request): void
		{
			$keyBank = GroupHelpers::group_by('bank_id', $request['business'], 'bank_id');
			foreach ($keyBank as $key => $value) {
				$pay = Payment::create([
					'bank_id' => $key,
					'user_id' => auth()->user()->id
				]);

				foreach ($value as $valueBusiness) {
					$pay->reinsurers()->sync($value);
					$business = Businesse::find($valueBusiness['paymentable_id']);
					if (($business->prime_a_recevoir - ($valueBusiness['montant_recu'] + $business->montant_recu)) <= 0) {
						$business->update([
							'statut' => 1,
							'montant_recu' => ($valueBusiness['montant_recu'] + $business->montant_recu),
							'montant_reversable' => ($valueBusiness['montant_recu'] + $business->montant_reversable)
						]);
					} else {
						$business->update([
							'statut' => 0,
							'montant_recu' => ($business->montant_recu + $valueBusiness['montant_recu']),
							'montant_reversable' => ($business->montant_reversable + $valueBusiness['montant_recu']),
						]);
					}
				}
			}
		}

		final public function storepayreas(Request $request): redirectResponse
		{
			// Ce helpers supprime le champ bank_id dans le tableau et le renvoie dans un format ou on peut sync
			$keyBank = GroupHelpers::group_by('bank_id', $request['business'], 'bank_id');
			foreach ($keyBank as $key => $value) {
				$pay = request()?->user()->payments()->create(['bank_id' => $key]);

				foreach ($value as $valueBusiness) {
					$business_id = $valueBusiness['businessid'];
					$businesse = Businesse::findOrFail($business_id);
					unset($valueBusiness['businessid'], $valueBusiness['bank_id_reinsurer']);
					$pay->reinsurers()->sync([$valueBusiness['paymentable_id'] => $valueBusiness]);
					$reinsurer = Reinsurer::where('id', $valueBusiness['paymentable_id'])->with('businesses')->firstOrFail();
					$businesses_reinsurer = $reinsurer->businesses->where('id', $business_id)->firstOrFail();

					if (($businesse->prime_a_recevoir - $businesse->montant_recu) <= 0) {

						if (($businesses_reinsurer->pivot->prime_reassurance - (float)$valueBusiness['montant_recu']) < 0) {
							return redirect()->back()->with('message', 'sinistre de commission');
						}

						$pay->reinsurers[0]->businesses()->updateExistingPivot($business_id, [
							'statut_payment' => 1,
							'montant_reverser' => $valueBusiness['montant_recu'] + $businesse['montant_reverser']
						]);
						return redirect()->back()->with('message', 'soldée partiellement');
					}

					$pay->reinsurers[0]->businesses()->updateExistingPivot($business_id, [
						'montant_reverser' => $valueBusiness['montant_recu'] + $businesse['montant_reverser']
					]);
					return redirect()->back()->with('message', 'affaire soldée partiellement');
				}
			}
			return redirect()->back();

		}
	}
