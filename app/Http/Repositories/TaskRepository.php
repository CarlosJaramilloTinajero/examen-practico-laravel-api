<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Interfaces\ICRUDRepositoy;
use App\Http\Repositories\Interfaces\IFiltersRespository;
use App\Models\Task;
use Illuminate\Database\Eloquent\Builder;

class TaskRepository implements ICRUDRepositoy, IFiltersRespository
{
    public function getAllModels(array $relations = []): Builder
    {
        return Task::query()->with($relations);
    }

    public function createModel(array $data): false|Task
    {
        return Task::create($data);
    }

    public function getModel(string $id): Task|null
    {
        return Task::with(['company' => function ($query) {
            $query->select('id', 'name', 'sector');
        }])->find($id);
    }

    public function updateModel(string $id, array $data): bool
    {
        return Task::where('id', $id)->update($data);
    }

    public function getModelsByFilters(array $filters = [], Builder|null $query = null): Builder
    {
        if (!$query) {
            $query = $this->getAllModels([
                'company' => function ($query) {
                    $query->select('id', 'name', 'sector');
                },
                'user' => function ($query) {
                    $query->select('id', 'name', 'email');
                }
            ]);
        }

        foreach ($filters as $key => $value) {
            switch ($key) {
                case 'search':
                    $query->where(function ($q) use ($value) {
                        $q->where('name', 'like', "%$value%");
                        $q->orWhere('description', 'like', "%$value%");
                        $q->orWhere('user', 'like', "%$value%");
                    });
                    break;

                case 'company':
                    $query->where('company_id', $value);
                    break;
            }
        }

        return $query;
    }
}
