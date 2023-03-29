<?php

	namespace App\Enums;

	enum TypeCession: string
	{
		case CLF = 'Cession Légale au 1er Franc';
		case CF = 'Cession Légale Facs';
		case CLT = 'Cession Légale Traités';
	}
