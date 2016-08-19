<?php

namespace App\ValueObjects;

/**
 * Value objects are an important part of any system because they give context and
 * allow to handle custom validations among other things.
 * reference http://martinfowler.com/bliki/ValueObject.html
*/

class Agent
{
	private $zipCode;

	public function __construct($zipCode=0)
	{
		if (!is_numeric($zipCode)) throw new \Exception('This is not a valid zipcode');

		$this->zipCode = $zipCode;
	}

	public function value()
	{
		return $this->zipCode;
	}
}