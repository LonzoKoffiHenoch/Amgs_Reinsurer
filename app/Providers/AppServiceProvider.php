<?php

	namespace App\Providers;

	use Illuminate\Support\ServiceProvider;
	use Inertia\Inertia;

	class AppServiceProvider extends ServiceProvider
	{
		/**
		 * Register any application services.
		 */
		final public function register(): void
		{

		}

		/**
		 * Bootstrap any application services.
		 */
		final public function boot(): void
		{
			Inertia::share('data', static function () {
				return [
					'auth' => [
					],

				];
			});
		}
	}
