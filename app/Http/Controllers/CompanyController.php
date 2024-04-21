<?php

namespace App\Http\Controllers;

use App\Helpers\HelpersController;
use App\Http\Services\CompanyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    protected $helpersController, $companyService;

    public function __construct(HelpersController $helpersController, CompanyService $companyService)
    {
        $this->helpersController  = $helpersController;
        $this->companyService = $companyService;
    }

    function index(Request $request)
    {
        try {
            $filters = $request->only(['search', 'page', 'perPage']);

            if (!$companies = $this->companyService->getModelsByFilters($filters)) {
                return $this->helpersController->responseWithFailApiMsg();
            }

            $dataCompanies = $companies['companies_paginated'] ?? $companies['companies'];

            return $this->helpersController->responseSuccessApi($dataCompanies);
        } catch (\Exception $e) {
            report($e);
            return $this->helpersController->respondWithInternalServerError();
        }
    }

    function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'sector' => 'required|in:tecnologia,salud,educacion'
            ]);

            if ($validator->fails()) {
                if ($validator->fails()) {
                    return $this->helpersController->responseWithFailApiMsg('Bad request | ' . str_replace('.', '', implode(', ', collect($validator->errors()->toArray())->map(function ($value) {
                        return implode(', ', $value);
                    })->toArray())) . '.', 400);
                }
            }

            if (!$model = $this->companyService->createModel([
                'name' => $request->name,
                'sector' => $request->sector
            ])) {
                return $this->helpersController->responseWithFailApiMsg();
            }

            return $this->helpersController->responseSuccessApi($model);
        } catch (\Exception $e) {
            report($e);
            return $this->helpersController->respondWithInternalServerError();
        }
    }

    function update(Request $request, string $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'sector' => 'required|in:tecnologia,salud,educacion'
            ]);

            if ($validator->fails()) {
                if ($validator->fails()) {
                    return $this->helpersController->responseWithFailApiMsg('Bad request | ' . str_replace('.', '', implode(', ', collect($validator->errors()->toArray())->map(function ($value) {
                        return implode(', ', $value);
                    })->toArray())) . '.', 400);
                }
            }

            if (!$this->companyService->updateModel($id, [
                'name' => $request->name,
                'sector' => $request->sector
            ])) {
                return $this->helpersController->responseWithFailApiMsg();
            }

            return $this->helpersController->responseSuccessApi();
        } catch (\Exception $e) {
            report($e);
            return $this->helpersController->respondWithInternalServerError();
        }
    }

    function destroy(string $id)
    {
        try {
            return $this->companyService->deleteModel($id) ? $this->helpersController->responseSuccessApi() : $this->helpersController->responseWithFailApiMsg('Error al borrar la compañia');
        } catch (\Exception $e) {
            report($e);
            return $this->helpersController->respondWithInternalServerError();
        }
    }
}
