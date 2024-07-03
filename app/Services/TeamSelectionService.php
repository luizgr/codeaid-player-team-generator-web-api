<?php

namespace App\Services;

use App\Enums\PlayerPosition;
use App\Enums\PlayerSkill;
use App\Exceptions\InvalidPlayerPositionException;
use App\Exceptions\InvalidPlayerSkillException;
use App\Exceptions\NotEnoughPlayersException;
use App\Exceptions\RepeatedSpecificationException;
use App\Repositories\PlayerRepositoryInterface;

class TeamSelectionService
{
    public PlayerRepositoryInterface $playerRepository;

    public function __construct(PlayerRepositoryInterface $playerRepository)
    {
        $this->playerRepository = $playerRepository;
    }

    public function getSpecificationPlayers(array $specifications)
    {
        $this->validateSpecifications($specifications);

        $selectionTeam = collect([]);

        foreach ($specifications as $specification) {
            $players = $this->playerRepository->skillestByPosition(
                $specification["mainSkill"],
                $specification["position"],
                $specification["numberOfPlayers"]
            );
            
            $selectionTeam = $selectionTeam->concat($players);

            if (count($players) < $specification["numberOfPlayers"]) {

                $completePlayers = $this->playerRepository->skillestByPosition(
                    null,
                    $specification["position"],
                    $specification["numberOfPlayers"] - count($players)
                );

                if (count($completePlayers) + count($players) != $specification["numberOfPlayers"])
                    throw new NotEnoughPlayersException(
                        sprintf("Insufficient number of players for position: %s.", $specification["position"])
                    );

                $selectionTeam = $selectionTeam->concat($completePlayers);
            }
        }

        return $selectionTeam;
    }

    public function validateSpecifications(array &$specifications)
    {
        foreach ($specifications as $specification) {
            $playerPosition = PlayerPosition::tryFrom($specification["position"]) 
                ?? throw new InvalidPlayerPositionException(sprintf(
                    "Invalid value for position: %s", $specification["position"]
                ));

            $playerSkill = PlayerSkill::tryFrom($specification["mainSkill"])
                ?? throw new InvalidPlayerSkillException(sprintf(
                    "Invalid value for skill: %s", $specification["mainSkill"]
                ));;

            $search = array_filter(
                $specifications,
                function ($searchSpec) use ($playerPosition, $playerSkill) {
                    return $searchSpec["position"] == $playerPosition
                        && $searchSpec["mainSkill"] == $playerSkill;
                }
            );

            if (count($search) > 1)
                throw new RepeatedSpecificationException("Repeated player specifications.");
        }
    }
}