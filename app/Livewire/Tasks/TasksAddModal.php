<?php

namespace App\Livewire\Tasks;

use App\Models\Company;
use App\Models\Task;
use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Component;

class TasksAddModal extends Component
{
    #[Validate([
        'formData.name' => 'required|min:3',
        'formData.description' => 'required|min:10',
        'formData.user_id' => 'required|numeric|exists:users,id',
        'formData.company_id' => 'required|numeric|exists:companies,id',
    ])]
    public $formData = [
        'name' => '',
        'description' => '',
        'user_id' => null,
        'company_id' => null
    ];

    public $users = [], $companies = [];

    function mount()
    {
        $this->users = User::all();
        $this->companies = Company::all();
    }

    public function render()
    {
        return view('livewire.tasks.tasks-add-modal');
    }

    function submit()
    {
        // Añadir los mensajes de error al validar el formulario
        $this->validate();

        if (!$user = User::find($this->formData['user_id'])) {
            // Añadir mensaje de error
            return;
        }

        if (!Task::create(array_merge($this->formData, ['user' => $user->name]))) {
            // Añadir mensaje de error
            return;
        }

        $this->formData = [
            'name' => '',
            'description' => '',
            'user_id' => null,
            'company_id' => null
        ];

        //Mostrar mensaje de exito

        // Despues de agregar la compañia
        $this->dispatch('update-table');
    }
}
