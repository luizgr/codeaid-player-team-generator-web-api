<?php

namespace App\Repositories;

interface PlayerRepositoryInterface
{
    public function all();

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);

    public function find($id);

    public function skillestByPosition($skill, $position, $limit);
}