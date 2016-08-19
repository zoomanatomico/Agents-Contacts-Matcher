<?php

namespace App\Http\Controllers;

use App\Matchers\AgentsToContactsMatcher;
use App\Calculators\ZipCodeApiClient;
use Illuminate\Http\Request;
use App\ValueObjects\Agent;
use App\Http\Requests;
use App\Readers\CSV;

class MainController extends Controller
{
    public function index(AgentsToContactsMatcher $agentsToContactsMatcher)
    {
    	$matcher = new $agentsToContactsMatcher(new CSV(), new ZipCodeApiClient());
    	$matcher->getContactsWithAgent();
    }
}