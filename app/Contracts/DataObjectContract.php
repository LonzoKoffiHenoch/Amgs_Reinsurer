<?php

	namespace App\Contracts;

	interface DataObjectContract
	{
		public function toArray(): array;
	}