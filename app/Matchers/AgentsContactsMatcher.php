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

	public function __construct(CSV $reader, ZipCodeApiClient $zipCodeApiClient, Agent $agentA, Agent $agentB) {
		$this->contactsData = $reader->fetchContacts();
		$this->zipCodeAgentA = $agentA->value();
		$this->zipCodeAgentB = $agentB->value();	
		$this->ZipCodeApiClient = $zipCodeApiClient;
	}

	public function getContactsWithAgent()
	{
		$xf = t\comp(
   			t\map(function ($value) {

   				$zipCodeContact = $value[1];

   				$distanceToAgentA = $this->ZipCodeApiClient->getDistanceInKms($zipCodeContact, $this->zipCodeAgentA);
   				$distanceToAgentB = $this->ZipCodeApiClient->getDistanceInKms($zipCodeContact, $this->zipCodeAgentB);

				$matchedContact = [
					'name' => $value[0],
					'zipCode' => $zipCodeContact,
					'agentZipCode' => $this->getZipCodeOfAssignedAgent($distanceToAgentA, $distanceToAgentB)
				];

   			 	return $matchedContact;
   			})
		);

		return t\transduce($xf, t\array_reducer(), $this->contactsData);
	}

	private function getZipCodeOfAssignedAgent($distanceToAgentA, $distanceToAgentB) 
	{
		return ($distanceToAgentA <= $distanceToAgentB) ? $this->zipCodeAgentA : $this->zipCodeAgentB;
	}
}