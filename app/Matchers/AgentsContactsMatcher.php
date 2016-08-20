<?php 

namespace App\Matchers;

use App\Calculators\ZipCodeApiClient;
use Transducers as t;
use App\Readers\CSV;

class AgentsContactsMatcher 
{
	protected $contactsData;
	protected $zipCodeApiClient;
	protected $zipCodeAgentA;
	protected $zipCodeAgentB;

	/**
	 * For decoupling and testing is better to inject the dependencies in the constructor.
	 * http://martinfowler.com/articles/injection.html
	 */
	public function __construct(CSV $reader, ZipCodeApiClient $zipCodeApiClient, $zipCodeAgentA=0, $zipCodeAgentB=0) {
		$this->contactsData = $reader->fetchContacts();
		$this->zipCodeApiClient = $zipCodeApiClient;
		$this->zipCodeAgentA = $zipCodeAgentA;
		$this->zipCodeAgentB = $zipCodeAgentB;
	}

	/**
	 *
	 * Main algorithm, this matches every contact loaded from the CSV with the nearest agent
	 * using the zipCode as a meter of proximity.
	 *
	 * @return array [['name' => 'jim', 'zipCode' => 123, 'agentZipCode' => 133]]
	 */
	public function getContactsWithAgent()
	{

		//To avoid loading all the processed data into memory a transducer is used,
		//In this case every contact is being processed once a time in memory.
		$transformer = t\comp(
   			t\map(function ($value) {

   				$zipCodeContact = $value[1];

   				$distanceToAgentA = $this->zipCodeApiClient->getDistanceInKms($zipCodeContact, $this->zipCodeAgentA);
   				$distanceToAgentB = $this->zipCodeApiClient->getDistanceInKms($zipCodeContact, $this->zipCodeAgentB);

				$matchedContact = [
					'name' => $value[0],
					'zipCode' => $zipCodeContact,
					'agentZipCode' => $this->getZipCodeOfAssignedAgent($distanceToAgentA, $distanceToAgentB)
				];

   			 	return $matchedContact;
   			})
		);

		return t\transduce($transformer, t\array_reducer(), $this->contactsData);
	}

	/**
     *
     * given 2 distances the function validates wich agent is nearer to the contact 
     * and returns the zipCode of that agent.
	 *
	 * @param int $distanceToAgentA distance in kms from contact to agentA location
	 * @param int $distanceToAgentB distance in kms from contact to agentB location
	 * @return int
	 */
	private function getZipCodeOfAssignedAgent($distanceToAgentA, $distanceToAgentB) 
	{
		return ($distanceToAgentA <= $distanceToAgentB) ? $this->zipCodeAgentA : $this->zipCodeAgentB;
	}
}