<?php

namespace App\Http\Controllers;

use App\Matchers\AgentsContactsMatcher;
use App\Calculators\ZipCodeApiClient;
use Illuminate\Http\Request;
use App\ValueObjects\Agent;
use App\Http\Requests;
use App\Readers\CSV;

class MainController extends Controller
{
    public function index(AgentsContactsMatcher $agentsToContactsMatcher)
    {
    	$matcher = new $agentsToContactsMatcher(new CSV(), new ZipCodeApiClient());
    	dd($matcher->getContactsWithAgent());
    }
}