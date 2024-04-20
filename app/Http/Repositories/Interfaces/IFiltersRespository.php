<?php

namespace App\Http\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Builder;

interface IFiltersRespository extends IRepository
{
    public function getModelsByFilters(array $filters = [], Builder|null $query = null): Builder;
}
