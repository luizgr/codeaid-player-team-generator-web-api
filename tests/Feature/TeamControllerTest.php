<?php

// /////////////////////////////////////////////////////////////////////////////
// TESTING AREA
// THIS IS AN AREA WHERE YOU CAN TEST YOUR WORK AND WRITE YOUR TESTS
// /////////////////////////////////////////////////////////////////////////////

namespace Tests\Feature;


class TeamControllerTest extends PlayerControllerBaseTest
{
    public function test_sample()
    {
        $this->postJson(self::REQ_URI, [
            "name" => "player 1",
            "position" => "defender",
            "playerSkills" => [
                0 => [
                    "skill" => "strength",
                    "value" => 37
                ]
            ]
        ]);

        $this->postJson(self::REQ_URI, [
            "name" => "player 2",
            "position" => "midfielder",
            "playerSkills" => [
                0 => [
                    "skill" => "speed",
                    "value" => 90
                ]
            ]
        ]);

        $this->postJson(self::REQ_URI, [
            "name" => "player 3",
            "position" => "defender",
            "playerSkills" => [
                0 => [
                    "skill" => "strength",
                    "value" => 50
                ],
                1 => [
                    "skill" => "stamina",
                    "value" => 2
                ]
            ]
        ]);

        $this->postJson(self::REQ_URI, [
            "name" => "player 4",
            "position" => "midfielder",
            "playerSkills" => [
                0 => [
                    "skill" => "speed",
                    "value" => 50
                ]
            ]
        ]);

        $this->postJson(self::REQ_URI, [
            "name" => "player 5",
            "position" => "midfielder",
            "playerSkills" => [
                0 => [
                    "skill" => "defense",
                    "value" => 92
                ]
            ]
        ]);

        $this->postJson(self::REQ_URI, [
            "name" => "player 6",
            "position" => "defender",
            "playerSkills" => [
                0 => [
                    "skill" => "speed",
                    "value" => 100
                ]
            ]
        ]);

        $requirements = [
            [
                'position' => "midfielder",
                'mainSkill' => "speed",
                'numberOfPlayers' => 1
            ],
            [
                'position' => "defender",
                'mainSkill' => "strength",
                'numberOfPlayers' => 2
            ],
        ];

        $res = $this->postJson(self::REQ_TEAM_URI, $requirements);

        $json = $res->getData();

        $this->assertEquals($json[0]->name, "player 2");
        $this->assertEquals($json[1]->name, "player 3");
        $this->assertEquals($json[2]->name, "player 1");
    }
}
