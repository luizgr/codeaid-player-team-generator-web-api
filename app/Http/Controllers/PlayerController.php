<?php

// /////////////////////////////////////////////////////////////////////////////
// PLEASE DO NOT RENAME OR REMOVE ANY OF THE CODE BELOW. 
// YOU CAN ADD YOUR CODE TO THIS FILE TO EXTEND THE FEATURES TO USE THEM IN YOUR WORK.
// /////////////////////////////////////////////////////////////////////////////

namespace App\Http\Controllers;

use App\Http\Requests\PlayerRequest;
use App\Http\Resources\PlayerResource;
use App\Services\PlayerService;
use Illuminate\Http\Response;

class PlayerController extends Controller
{
    public PlayerService $playerService;

    public function __construct(PlayerService $playerService)
    {
        $this->playerService = $playerService;
    }

    public function index()
    {
        return response()->json(
            PlayerResource::collection(
                $this->playerService->getAvailablePlayers()
            ), Response::HTTP_OK
        );
    }

    public function show($id)
    {
        return response()->json(
            new PlayerResource(
                $this->playerService->getPlayer($id)
            ), Response::HTTP_OK
        );
    }

    public function store(PlayerRequest $request)
    {
        return response()->json(
            new PlayerResource(
                $this->playerService->createPlayer($request->validated())
            ), Response::HTTP_CREATED
        );
    }

    public function update(PlayerRequest $request, $id)
    {
        return response()->json(
            new PlayerResource(
                $this->playerService->updatePlayer($id, $request->validated())
            ), Response::HTTP_OK
        );
    }

    public function destroy($id)
    {
        return response(
            $this->playerService->deletePlayer($id), 
            Response::HTTP_NO_CONTENT
        );
    }
}
