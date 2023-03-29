<?php

	namespace App\Enums;

	enum TypeCalculation: string
	{
		case CC = 'Conservation Cédantes';
		case CPPVT = 'Cession Pool PVT';
		case CF = 'Cession Faculatative';
	}
