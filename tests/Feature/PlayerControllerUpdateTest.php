<?php

// /////////////////////////////////////////////////////////////////////////////
// TESTING AREA
// THIS IS AN AREA WHERE YOU CAN TEST YOUR WORK AND WRITE YOUR TESTS
// /////////////////////////////////////////////////////////////////////////////

namespace Tests\Feature;

use Illuminate\Http\Response;

class PlayerControllerUpdateTest extends PlayerControllerBaseTest
{
    public function test_sample()
    {
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
        $res = $this->putJson(self::REQ_URI . '1', $data);

        $res->assertStatus(Response::HTTP_OK);

        $json = $res->getData();

        $this->assertEquals($json->name, "test");
        $this->assertEquals($json->position, "defender");
        $this->assertEquals(count($json->playerSkills), 2);
    }
}
