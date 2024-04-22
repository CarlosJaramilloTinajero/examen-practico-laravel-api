<?php

namespace App\Livewire\Tasks;

use App\Models\Task;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class TasksTable extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    #[On('update-table')]
    public function render()
    {
        $tasks = $this->getTasksPagiated();
        return view('livewire.tasks.tasks-table', ['tasks' => $tasks]);
    }

    function getTasksPagiated()
    {
        return Task::with(['company', 'user'])->paginate(20);
    }

    function deleteTask(string $id)
    {
        if (!$task = Task::find($id)) {
            return;
        }

        if (!$task->delete()) {
            return;
        }

        $this->render();
    }
}
