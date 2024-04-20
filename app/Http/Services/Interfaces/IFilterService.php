<?php

namespace App\Http\Services\Interfaces;

interface IFilterService extends IService
{
    public function getModelsByFilters(array $filters = []): bool|array;
}
