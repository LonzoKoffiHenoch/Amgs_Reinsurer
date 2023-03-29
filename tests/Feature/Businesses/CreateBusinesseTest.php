<?php

	use App\Domains\Businesse\Models\Businesse;
	use App\Models\User;
	use function Pest\Laravel\actingAs;

	it('can create businesse', function () {

		$response = actingAs(user: User::factory()->create())
			->post(
				uri: route('business.store'),
				data: Businesse::factory()->create()->toArray()
			)->assertRedirect();

	});

	it('can be update businesse', function () {

	});