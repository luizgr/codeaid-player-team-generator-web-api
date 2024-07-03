<?php

// /////////////////////////////////////////////////////////////////////////////
// PLEASE DO NOT RENAME OR REMOVE ANY OF THE CODE BELOW. 
// YOU CAN ADD YOUR CODE TO THIS FILE TO EXTEND THE FEATURES TO USE THEM IN YOUR WORK.
// /////////////////////////////////////////////////////////////////////////////

namespace App\Http\Controllers;

use App\Http\Requests\TeamSelectionRequest;
use App\Http\Resources\PlayerResource;
use App\Services\TeamSelectionService;
use Illuminate\Http\Response;

class TeamSelectionController extends Controller
{
    public TeamSelectionService $teamSelectionService;

    public function __construct(TeamSelectionService $teamSelectionService)
    {
        $this->teamSelectionService = $teamSelectionService;
    }

    public function process(TeamSelectionRequest $request)
    {
        return response()->json(
            PlayerResource::collection(
                $this->teamSelectionService->getSpecificationPlayers($request->validated())
            ), Response::HTTP_OK
        );
    }
}
