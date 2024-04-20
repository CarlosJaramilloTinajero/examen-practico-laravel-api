<?php

namespace App\Http\Controllers;

use App\Helpers\HelpersController;
use App\Http\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    protected $helpersController, $taskService;

    public function __construct(HelpersController $helpersController, TaskService $taskService)
    {
        $this->helpersController  = $helpersController;
        $this->taskService = $taskService;
    }

    function index(Request $request)
    {
        try {
            // Buscar por nombre, descripcion y por company_id
            $filters = $request->only(['search', 'page', 'perPage', 'company']);

            if (!$tasks = $this->taskService->getModelsByFilters($filters)) {
                return $this->helpersController->responseWithFailApiMsg();
            }

            $dataTasks = $tasks['tasks_paginated'] ?? $tasks['tasks'];

            return $this->helpersController->responseSuccessApi($dataTasks);
        } catch (\Exception $e) {
            report($e);
            return $this->helpersController->respondWithInternalServerError();
        }
    }

    function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|min:5',
                'description' => 'required|min:20',
                'user_id' => 'required|numeric',
                'company_id' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return $this->helpersController->responseWithFailApiMsg('Bad request', 400);
            }

            if (!$model = $this->taskService->createModel([
                'name' => $request->name,
                'descrition' => $request->descrition,
                'user_id' => $request->user_id,
                'company_id' => $request->company_id,
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
                'name' => 'required|min:5',
                'description' => 'required|min:20',
                'user_id' => 'required|numeric',
                'company_id' => 'required|numeric',
                'start_at' => 'nullable|date',
                'expired_at' => 'nullable|date'
            ]);

            if ($validator->fails()) {
                return $this->helpersController->responseWithFailApiMsg('Bad request', 400);
            }

            if (!$this->taskService->updateModel($id, [
                'name' => $request->name,
                'descrition' => $request->descrition,
                'user_id' => $request->user_id,
                'company_id' => $request->company_id,
                'start_at' => $request->start_at ? $request->start_at : null,
                'expired_at' => $request->expired_at ? $request->expired_at : null
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
            return $this->taskService->deleteModel($id) ? $this->helpersController->responseSuccessApi() : $this->helpersController->responseWithFailApiMsg('Error al borrar la tarea');
        } catch (\Exception $e) {
            report($e);
            return $this->helpersController->respondWithInternalServerError();
        }
    }
}
