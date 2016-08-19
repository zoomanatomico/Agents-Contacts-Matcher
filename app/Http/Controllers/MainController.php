<?php

namespace App\Http\Controllers;

use App\Matchers\AgentsContactsMatcher;
use App\Calculators\ZipCodeApiClient;
use Illuminate\Http\Request;
use App\ValueObjects\AgentZipCode;
use App\Http\Requests;
use App\Readers\CSV;

class MainController extends Controller
{
    public function index()
    {
    	return view('home');
    }

    public function match(AgentsContactsMatcher $agentsToContactsMatcher)
    {
    	$agentA = new AgentZipCode(request()->input('agent_a'));
    	$agentB = new AgentZipCode(request()->input('agent_b'));

    	$matcher = new $agentsToContactsMatcher(new CSV(), new ZipCodeApiClient(), $agentA, $agentB);

    	return view('home')->with('matches', $matcher->getContactsWithAgent());
    }
}