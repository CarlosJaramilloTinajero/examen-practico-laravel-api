<?php

namespace App\Http\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface ICRUDRepositoy extends IRepository
{
    public function getAllModels(array $relations = []): Builder;

    public function createModel(array $data): false|Model;

    public function getModel(string $id): Model|null;

    public function updateModel(string $id, array $data): bool;
}
