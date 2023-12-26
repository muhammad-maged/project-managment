<?php

namespace App\Http\Controllers;

use App\Services\SlackService;
use Illuminate\Http\Request;

class SlackController extends Controller
{
    private $slackService;

    public function __construct(SlackService $slackService)
    {
        $this->slackService = $slackService;
    }

    public function integrateWorkspace(Request $request)
    {
        return $this->slackService->integrateWorkspace($request->all());
    }

    public function listChannels()
    {
        return $this->slackService->listChannels();
    }
}
