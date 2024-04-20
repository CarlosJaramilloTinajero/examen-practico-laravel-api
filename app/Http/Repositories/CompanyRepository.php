<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Interfaces\ICRUDRepositoy;
use App\Http\Repositories\Interfaces\IFiltersRespository;
use App\Models\Company;
use Illuminate\Database\Eloquent\Builder;

class CompanyRepository implements ICRUDRepositoy, IFiltersRespository
{
    public function getAllModels(array $relations = []): Builder
    {
        return Company::query()->with($relations);
    }

    public function createModel(array $data): false|Company
    {
        return Company::create($data);
    }

    public function getModel(string $id): Company|null
    {
        return Company::find($id);
    }

    public function updateModel(string $id, array $data): bool
    {
        return Company::where('id', $id)->update($data);
    }

    public function getModelsByFilters(array $filters = [], Builder|null $query = null): Builder
    {
        if (!$query) {
            $query = $this->getAllModels(['tasks' => function ($query) {
                $query->select('id', 'name', 'description', 'user', 'start_at', 'expired_at');
            }]);
        }

        foreach ($filters as $key => $value) {
            switch ($key) {
                case 'search':
                    $query->where('name', 'like', "%$value%");
                    break;
            }
        }

        return $query;
    }
}
