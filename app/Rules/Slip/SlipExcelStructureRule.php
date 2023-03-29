<?php

	namespace App\Rules\Slip;

	use Illuminate\Contracts\Validation\Rule;

	class SlipExcelStructureRule implements Rule
	{

		public function __construct()
		{
			//
		}

		/**
		 * Determine if the validation rule passes.
		 */
		public function passes(string $attribute, mixed $value): bool
		{
			//
		}

		/**
		 * Get the validation error message.
		 * @return string
		 */
		public function message()
		{
			return 'The validation error message.';
		}
	}
