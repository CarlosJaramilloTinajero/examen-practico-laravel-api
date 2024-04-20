<?php

namespace App\Http\Services;

use App\Http\Repositories\CompanyRepository;
use App\Http\Services\Interfaces\ICRUDService;
use App\Http\Services\Interfaces\IFilterService;
use App\Models\Company;
use Illuminate\Database\Eloquent\Collection;

class CompanyService implements ICRUDService, IFilterService
{

    protected $companyRepository;

    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    function getallModels(): bool|Collection
    {
        try {
            return $this->companyRepository->getAllModels()->get();
        } catch (\Exception $e) {
            report($e);
            return false;
        }
    }


    public function createModel(array $data): false|Company
    {
        try {
            return $this->companyRepository->createModel($data);
        } catch (\Exception $e) {
            report($e);
            return false;
        }
    }

    public function updateModel(string $id, array $data): bool
    {
        try {
            return $this->companyRepository->updateModel($id, $data);
        } catch (\Exception $e) {
            report($e);
            return false;
        }
    }

    public function deleteModel(string $id): bool
    {
        try {
            if (!$company = $this->companyRepository->getModel($id)) {
                return false;
            }

            return $company->delete();
        } catch (\Exception $e) {
            report($e);
            return false;
        }
    }

    public function getModelsByFilters(array $filters = []): bool|array
    {
        try {
            $queryByFilters = $this->companyRepository->getModelsByFilters($filters);
            $companiesPaginated = null;
            $companies = null;

            if (isset($filters['page']) && is_numeric($filters['page']) && $filters['page'] > 0) {
                $companiesPaginated = $queryByFilters
                    ->paginate(isset($filters['perPage']) && $filters['perPage'] > 0 ? $filters['perPage'] : 10);
            }

            $companies = $queryByFilters->get();

            return [
                'companies_paginated' => $companiesPaginated,
                'companies' => $companies
            ];
        } catch (\Exception $e) {
            report($e);
            return false;
        }
    }
}
