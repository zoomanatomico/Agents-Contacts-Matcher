<?php 

namespace App\Matchers;

use App\Calculators\ZipCodeApiClient;
use App\ValueObjects\Agent;
use Transducers as t;
use App\Readers\CSV;

class AgentsToContactsMatcher 
{
	protected $contactsData;
	protected $zipCodeAgentA;
	protected $zipCodeAgentB;
	protected $ZipCodeApiClient;

	public function __construct(CSV $reader, ZipCodeApiClient $zipCodeApiClient) {
		$this->contactsData = $reader->fetchContacts();
		$this->zipCodeAgentA = 1;
		$this->zipCodeAgentB = 2;	
		$this->ZipCodeApiClient = $zipCodeApiClient;
	}


	public function getContactsWithAgent()
	{

		$xf = t\comp(
   			t\map(function ($value) {
   			 return $this->ZipCodeApiClient->getDistanceInKms(32159,32404);
   			})
		);

		$result = t\transduce($xf, t\array_reducer(), $this->contactsData);

		dd($result);
	}
}