<?php

namespace App\Livewire\Companies;

use App\Models\Company;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class CompaniesTable extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    #[On('update-table')]
    public function render()
    {
        $companies = $this->getCompaniesPagiated();
        return view('livewire.companies.companies-table', ['companies' => $companies]);
    }

    function getCompaniesPagiated()
    {
        return Company::with('tasks')->paginate(20);
    }

    function deleteCompanie(string $id)
    {
        if (!$company = Company::find($id)) {
            return;
        }

        if (!$company->delete()) {
            return;
        }

        $this->render();
    }
}
