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
    public function index()
    {
    	return view('home');
    }

    public function match(AgentsContactsMatcher $agentsToContactsMatcher)
    {
    	$agentA = new Agent(request()->input('agent_a'));
    	$agentB = new Agent(request()->input('agent_b'));

    	$matcher = new $agentsToContactsMatcher(new CSV(), new ZipCodeApiClient(), $agentA, $agentB);

    	return view('home')->with('matches', $matcher->getContactsWithAgent());
    }
}