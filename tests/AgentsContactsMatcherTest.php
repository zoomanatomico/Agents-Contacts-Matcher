<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Calculators\ZipCodeApiClient;
use App\ValueObjects\agentZipCode;
use App\Matchers\AgentsContactsMatcher;
use App\Readers\CSV;

class AgentsContactsMatcherTest extends TestCase
{
	/**
	 * Given this was the only class that didn't depend on anything external (API, fileSystem)
	 * a test was created for it, for testing the other classes integration tests are needed.
	 */
    public function test_given_valid_zip_codes_it_returns_a_matched_array() 
    {
    	//Reader Mock
    	$reader = $this->prophesize(CSV::class);
    	$reader->fetchContacts()->willReturn([['Johnny', 12345]]);

    	//DistanceByZipCode Mock
    	$zipCodeApiClient = $this->prophesize(ZipCodeApiClient::class);
        $zipCodeApiClient->getDistanceInKms(12345, 12346)->willReturn(10);
        $zipCodeApiClient->getDistanceInKms(12345, 12347)->willReturn(11);

    	//Agents
        $zipCodeAgentA = 12346;
        $zipCodeAgentB = 12347;
        
    	$agentsContactsMatcher = new AgentsContactsMatcher($reader->reveal(), $zipCodeApiClient->reveal(),
    		$zipCodeAgentA, $zipCodeAgentB);

    	$matches = $agentsContactsMatcher->getContactsWithAgent();

    	$this->assertEquals($matches, [["name" => "Johnny", "zipCode" => 12345, "agentZipCode" => 12346]]);

    }

    
}
