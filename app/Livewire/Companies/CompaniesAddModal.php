<?php

namespace App\Livewire\Companies;

use App\Models\Company;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CompaniesAddModal extends Component
{

    #[Validate([
        'formData.name' => 'required|min:3',
        'formData.sector' => 'required|in:tecnologia,salud,educacion'
    ])]
    public $formData = [
        'name' => '',
        'sector' => ''
    ];

    public function render()
    {
        return view('livewire.companies.companies-add-modal');
    }

    function submit()
    {
        // Añadir los mensajes de error al validar el formulario
        $this->validate();

        if (!Company::create($this->formData)) {
            // Añadir mensaje de error
            return;
        }

        $this->formData = [
            'name' => '',
            'sector' => ''
        ];

        // Mostrar mensaje de exito

        // Despues de agregar la compañia
        $this->dispatch('update-table');
    }
}
