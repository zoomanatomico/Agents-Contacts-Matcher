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

		$callToZipCodeApi = $this->client->request('GET', $requestData);
		
		return json_decode($callToZipCodeApi->getBody()->getContents())->distance;
	}
}