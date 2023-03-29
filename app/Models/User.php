<?php

	namespace App\Models;

	use App\Domains\Businesse\Models\Businesse;
	use App\Domains\Payment\Models\Payment;
	use App\Models\Scopes\Searchable;
	use Illuminate\Database\Eloquent\Factories\HasFactory;
	use Illuminate\Database\Eloquent\Relations\HasMany;
	use Illuminate\Database\Eloquent\SoftDeletes;
	use Illuminate\Foundation\Auth\User as Authenticatable;
	use Illuminate\Notifications\Notifiable;
	use Spatie\Permission\Traits\HasRoles;

	final class User extends Authenticatable
	{
		use Notifiable;
		use HasFactory;
		use Searchable;
		use SoftDeletes;
		use HasRoles;

		protected $fillable = ['name', 'username', 'email', 'password'];

		protected array $searchableFields = ['*'];

		protected $hidden = ['password', 'remember_token'];

		protected $casts = [
			'email_verified_at' => 'datetime',
		];

		public function businesses(): hasMany
		{
			return $this->hasMany(Businesse::class);
		}

		public function reinsurers(): hasMany
		{
			return $this->hasMany(Reinsurer::class);
		}

		public function banks(): hasMany
		{
			return $this->hasMany(Bank::class);
		}

		public function payments(): hasMany
		{
			return $this->hasMany(Payment::class);
		}

		public function transferors(): hasMany
		{
			return $this->hasMany(Transferor::class);
		}

		public function branches(): hasMany
		{
			return $this->hasMany(Branche::class);
		}


		public function isSuperAdmin(): bool
		{
			return in_array($this->email, config('auth.super_admins'), true);
		}
	}
