<?php

// /////////////////////////////////////////////////////////////////////////////
// TESTING AREA
// THIS IS AN AREA WHERE YOU CAN TEST YOUR WORK AND WRITE YOUR TESTS
// /////////////////////////////////////////////////////////////////////////////

namespace Tests\Feature;

use Illuminate\Http\Response;

class PlayerControllerListingTest extends PlayerControllerBaseTest
{
    public function test_sample()
    {
        $res = $this->get(self::REQ_URI);

        $res->assertStatus(Response::HTTP_OK);
        $res->assertJson([]);

        $data = [
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
        ];

        $this->postJson(self::REQ_URI, $data);

        $res = $this->get(self::REQ_URI);

        $res->assertStatus(Response::HTTP_OK);
        $res->assertJson([$data]);
    }
}
