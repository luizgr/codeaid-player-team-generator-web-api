<?php

namespace App\Services;

use App\Enums\PlayerPosition;
use App\Enums\PlayerSkill;
use App\Exceptions\InvalidPlayerPositionException;
use App\Exceptions\InvalidPlayerSkillException;
use App\Exceptions\PlayerWithoutSkillException;
use App\Models\Player;
use App\Repositories\PlayerRepositoryInterface;

class PlayerService
{
    /**
     * The player repository.
     *
     * @var PlayerRepositoryInterface
     */
    public PlayerRepositoryInterface $playerRepository;

    public function __construct(PlayerRepositoryInterface $playerRepository)
    {
        $this->playerRepository = $playerRepository;
    }

    /**
     * Get array of the available players.
     *
     * @return array<Player>
     */
    public function getAvailablePlayers()
    {
        return $this->playerRepository->all();
    }

    /**
     * Get player by ID.
     *
     * @param  integer  $id
     * @return Player
     */
    public function getPlayer($id) : Player
    {
        return $this->playerRepository->find($id);
    }

    /**
     * Create a new player.
     *
     * @param  array  $data
     * @return Player
     */
    public function createPlayer(array $data) : Player
    {
        if (!isset($data["position"]) || !PlayerPosition::tryFrom($data["position"]))
            throw new InvalidPlayerPositionException(sprintf(
                "Invalid value for position: %s", $data["position"]
            ));

        if (!isset($data["playerSkills"]) || count($data["playerSkills"]) < 1)
            throw new PlayerWithoutSkillException("The player needs to have at least one skill.");

        foreach ($data["playerSkills"] as $playerSkill) {
            if (!PlayerSkill::tryFrom($playerSkill["skill"]))
                throw new InvalidPlayerSkillException(sprintf(
                    "Invalid value for skill: %s", $playerSkill["skill"]
                ));
        }

        return $this->playerRepository->create($data);
    }

    /**
     * Update player by ID.
     *
     * @param  integer  $id
     * @param  array  $data
     * @return Player
     */
    public function updatePlayer($id, array $data)
    {
        if (!isset($data["position"]) || !PlayerPosition::tryFrom($data["position"]))
            throw new InvalidPlayerPositionException(sprintf(
                "Invalid value for position: %s", $data["position"]
            ));

        if (isset($data["playerSkills"]))
            foreach ($data["playerSkills"] as $playerSkill) {
                if (!PlayerSkill::tryFrom($playerSkill["skill"]))
                    throw new InvalidPlayerSkillException(sprintf(
                        "Invalid value for skill: %s", $playerSkill["skill"]
                    ));
            }

        return $this->playerRepository->update($id, $data);
    }

    /**
     * Delete player by ID.
     *
     * @return void
     */
    public function deletePlayer($id) : void
    {
        $this->playerRepository->delete($id);
    }
}