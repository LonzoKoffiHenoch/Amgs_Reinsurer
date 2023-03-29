<?php

	namespace App\Http\Controllers;

	use App\Models\User;
	use Illuminate\Http\JsonResponse;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Hash;
	use Illuminate\Validation\Rules;


	final class UserController extends Controller
	{
		public function store(Request $request): void
		{
			$request->validate([
				'name' => 'required|string|max:255',
				'email' => 'required|string|email|max:255|unique:users',
				'phone' => 'required',
				'password' => [
					'required',
					'confirmed',
					Rules\Password::defaults()
				],
			]);

			$user = User::create([
				'name' => $request->name,
				'email' => $request->email,
				'phone' => $request->phone,
				'password' => Hash::make($request->password),
			]);
		}


		public function edit(User $user): JsonResponse
		{
			return response()->json([
				'user' => $user
			]);
		}


		public function update(Request $request, User $user)
		{
			$request->validate([
				'name' => 'required|string|max:255',
				'email' => 'required|string|email|max:255',
				'phone' => 'required',
			]);
			$user->update(['name' => $request->name, 'email' => $request->email, 'phone' => $request->phone]);
		}


		public function destroy(User $user): void
		{
			$user->delete();
		}
	}
