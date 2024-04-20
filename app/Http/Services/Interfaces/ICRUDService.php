<?php

namespace App\Http\Services\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface ICRUDService extends IService
{
    function getallModels(): bool|Collection;

    public function createModel(array $data): false|Model;

    public function updateModel(string $id, array $data): bool;

    public function deleteModel(string $id): bool;
}
