<?php

namespace App\Http\Services;

use App\Http\Repositories\TaskRepository;
use App\Http\Services\Interfaces\ICRUDService;
use App\Http\Services\Interfaces\IFilterService;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class TaskService implements ICRUDService, IFilterService
{

    protected $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    function getallModels(): bool|Collection
    {
        try {
            return $this->taskRepository->getAllModels()->get();
        } catch (\Exception $e) {
            report($e);
            return false;
        }
    }

    public function createModel(array $data): false|Task
    {
        try {
            if (!$user = User::find($data['user_id'])) return false;

            // Validamos que no haya mas de 5 tareas pendientes para el usuario
            if ($user->tasks->count() > 5) return false;

            $data = array_merge($data, ['user' => $user->name]);
            return $this->taskRepository->createModel($data);
        } catch (\Exception $e) {
            report($e);
            return false;
        }
    }

    public function updateModel(string $id, array $data): bool
    {
        try {
            if (!$user = User::find($data['user_id'])) return false;
            $data = array_merge($data, ['user' => $user->name]);
            return $this->taskRepository->updateModel($id, $data);
        } catch (\Exception $e) {
            report($e);
            return false;
        }
    }

    public function deleteModel(string $id): bool
    {
        try {
            if (!$task = $this->taskRepository->getModel($id)) {
                return false;
            }

            return $task->delete();
        } catch (\Exception $e) {
            report($e);
            return false;
        }
    }

    public function getModelsByFilters(array $filters = []): bool|array
    {
        try {
            $queryByFilters = $this->taskRepository->getModelsByFilters($filters);
            $tasksPaginated = null;
            $tasks = null;

            if (isset($filters['page']) && is_numeric($filters['page']) && $filters['page'] > 0) {
                $tasksPaginated = $queryByFilters
                    ->paginate(isset($filters['perPage']) && $filters['perPage'] > 0 ? $filters['perPage'] : 10);
            }

            $tasks = $queryByFilters->get();

            return [
                'tasks_paginated' => $tasksPaginated,
                'tasks' => $tasks
            ];
        } catch (\Exception $e) {
            report($e);
            return false;
        }
    }
}
