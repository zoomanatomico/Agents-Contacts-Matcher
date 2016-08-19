<?php

namespace App\Calculators;

interface distanceByZipCode
{
	public function getDistanceInKms($zipCode1, $zipCode2);
}