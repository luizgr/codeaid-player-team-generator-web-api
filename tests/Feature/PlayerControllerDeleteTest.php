<?php

// /////////////////////////////////////////////////////////////////////////////
// TESTING AREA
// THIS IS AN AREA WHERE YOU CAN TEST YOUR WORK AND WRITE YOUR TESTS
// /////////////////////////////////////////////////////////////////////////////

namespace Tests\Feature;

use Illuminate\Http\Response;

class PlayerControllerDeleteTest extends PlayerControllerBaseTest
{

    public function test_sample()
    {
        $this->postJson(self::REQ_URI, [
            "name" => "test",
            "position" => "defender",
            "playerSkills" => [
                0 => [
                    "skill" => "attack",
                    "value" => 60
                ],
                1 => [
                    "skill" => "speed",
                    "value" => 80
                ]
            ]
        ]);
        
        $res = $this->delete(self::REQ_URI . '1');

        $res->assertStatus(Response::HTTP_UNAUTHORIZED);

        $token = config('auth.delete_player_token');

        $res = $this->withHeader('Authorization', 'Bearer ' . $token)->delete(self::REQ_URI . '1');

        $res->assertStatus(Response::HTTP_NO_CONTENT);
    }
}
