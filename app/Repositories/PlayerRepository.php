<?php

namespace App\Repositories;

use App\Models\Player;

class PlayerRepository implements PlayerRepositoryInterface
{
    public function all()
    {
        return Player::all();
    }

    public function find($id)
    {
        return Player::findOrFail($id);
    }

    public function create(array $data)
    {
        $player = Player::create($data);

        if (isset($data['playerSkills']))
            foreach ($data['playerSkills'] as $skill) 
                $player->skills()->create($skill);

        $player->refresh();

        return $player;
    }

    public function update($id, array $data)
    {
        $player = Player::findOrFail($id);
        $player->fill($data);
        $player->save();
        
        if (isset($data['playerSkills']))
            foreach ($data['playerSkills'] as $skill) 
                $player->skills()->updateOrCreate(
                    ['skill' => $skill['skill']], 
                    ['value' => $skill['value']]
                );

        $player->refresh();

        return $player;
    }

    public function delete($id) : void
    {
        Player::findOrFail($id)->delete();
    }

    public function skillestByPosition($skill, $position, $limit)
    {
        $players = Player::select(
            ["players.id", "players.name", "players.position"]
        )->join("player_skills", function ($join) {
            $join->on("players.id", "=", "player_skills.player_id");
        });

        $players = $players->where("players.position", $position);
        if (!is_null($skill)) $players = $players->where("player_skills.skill", $skill);
        $players = $players->limit($limit);
        $players = $players->orderBy("player_skills.value", "desc");
        $players = $players->groupBy("players.id");

        return $players->get();
    }
}