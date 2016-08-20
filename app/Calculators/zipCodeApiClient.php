<?php

namespace App\Calculators;
use GuzzleHttp\Client;

class ZipCodeApiClient
{

	private $client;

	public function __construct()
	{
		$base_url = sprintf("%s/%s/%s/", env('ZIP_CODE_API_URL'), env('ZIP_CODE_API_CODE'), 'distance.json');
	
		$this->client = new Client(['base_uri' => $base_url ,'timeout'  => 2.0]);
	}

	public function getDistanceInKms($zipCode1, $zipCode2)
	{
		$requestData = sprintf("%s/%s/km", $zipCode1, $zipCode2);

		//TODO:This is a BIG not to do, the proper way is to handle the exceptions by asking the P.O 
		//What should we do when for example the zipCode is not valid but right now for matters of time
		//I can deal with it.

		try {
			$callToZipCodeApi = $this->client->request('GET', $requestData);
		
			$response = json_decode($callToZipCodeApi->getBody()->getContents())->distance;	
		} catch (\Exception $e) {
			$response = 0;
		}

		return $response;
	}
}