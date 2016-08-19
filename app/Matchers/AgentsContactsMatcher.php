<?php 

namespace App\Matchers;

use App\Calculators\ZipCodeApiClient;
use App\ValueObjects\Agent;
use Transducers as t;
use App\Readers\CSV;

class AgentsContactsMatcher 
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

   				$zipCodeContact = $value[1];

   				$distanceToAgentA = $this->ZipCodeApiClient->getDistanceInKms($zipCodeContact, $this->zipCodeAgentA);
   				$distanceToAgentB = $this->ZipCodeApiClient->getDistanceInKms($zipCodeContact, $this->zipCodeAgentB);

   				$agentZipCode = $this->getZipCodeOfAssignedAgent($distanceToAgentA, $distanceToAgentB);
   				
   			 	$value[2] = $agentZipCode;

   			 	return $value;
   			})
		);

		return t\transduce($xf, t\array_reducer(), $this->contactsData);
	}

	private function getZipCodeOfAssignedAgent($distanceToAgentA, $distanceToAgentB) 
	{
		return ($distanceToAgentA <= $distanceToAgentB) ? $this->zipCodeAgentA : $this->zipCodeAgentB;
	}
}