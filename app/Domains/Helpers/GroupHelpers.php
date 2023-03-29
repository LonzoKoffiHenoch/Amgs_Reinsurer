<?php

	namespace App\Domains\Helpers;


	class GroupHelpers
	{

		final public static function group_by(string $key, array $data, string $delete = null): array|null
		{
			$result = [];
			foreach ($data as $val) {
				if (array_key_exists($key, $val)) {
					$result[$val[$key]][] = $val;
					foreach ($result as $ke => $valing) {
						foreach ($valing as $valingKey => $valueValing) {
							unset($result[$val[$key]][$valingKey][$delete]);
						}
					}
				} else {
					$result[""][] = $val;
				}
			}
			return $result;
		}
	}
