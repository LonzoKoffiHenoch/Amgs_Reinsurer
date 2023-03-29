<?php

	namespace App\Domains\Slip\Http\Requests;

	use Illuminate\Foundation\Http\FormRequest;

	final class SlipUploadRequest extends FormRequest
	{
		/**
		 * Determine if the user is authorized to make this request.
		 */
		public function authorize(): bool
		{
			return true;
		}

		/**
		 * Get the validation rules that apply to the request.
		 */
		public function rules(): array
		{

			return [
				'date_reception' => ['required', 'date'],
				'slip' => ['required', 'array']

			];
		}
	}
