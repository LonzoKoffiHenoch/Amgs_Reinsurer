<?php

	namespace App\Domains\Setting\Http\Requests;

	use Illuminate\Foundation\Http\FormRequest;

	final class ConventionActivityRequest extends FormRequest
	{
		/**
		 * Determine if the user is authorized to make this request.
		 * @return bool
		 */
		public function authorize(): bool
		{
			return true;
		}

		/**
		 * Get the validation rules that apply to the request.
		 * @return array
		 */
		public function rules(): array
		{

			return [
				'type' => ['required', 'string'],
				'activity' => ['required', 'string'],
				'price' => ['required',],
				'pays' => ['required',],
				'transferor' => ['required', 'array'],
			];
		}
	}
