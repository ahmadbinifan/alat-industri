<?php

namespace App\Livewire\equipment;

use Livewire\Component;
use Livewire\WithPagination;

class Equipment extends Component
{
    #[\Livewire\Attributes\On('refresh')]
    public function refresh()
    {
    }
    use WithPagination;
    public $perPage = 10;
    public $search = '';
    public $sortDirection = 'DESC';
    public $sortColumn = 'doc_no';

    public function doSort($column)
    {
        if ($this->sortColumn === $column) {
            $this->sortDirection = ($this->sortDirection == 'ASC') ? 'DESC' : 'ASC';
            return;
        }
        $this->sortColumn = $column;
        $this->sortDirection = 'ASC';
    }
    public function updatedPerPage()
    {
        $this->resetPage();
    }
    public function updatedSearch()
    {
        $this->resetPage();
    }
    public function render()
    {
        if (session('id_section') == "LEG" || session('id_section') == "HRD") {
            $data = \App\Models\Equipment_license::where('status', 'wait_adm_legal')->orWhere('status', 'wait_dep_hrd')->search($this->search)
                ->orderBy($this->sortColumn, $this->sortDirection)
                ->paginate($this->perPage);
        } elseif (session('id_section') == "HSE") {
            $data = \App\Models\Equipment_license::where('status', 'wait_adm_hse')->orWhere('status', 'wait_dep_hse')->search($this->search)
                ->orderBy($this->sortColumn, $this->sortDirection)
                ->paginate($this->perPage);
        } elseif (session('id_position') == "BUSINESS_CONTROL") {
            $data = \App\Models\Equipment_license::where('status', 'wait_budgetcontrol')->search($this->search)
                ->orderBy($this->sortColumn, $this->sortDirection)
                ->paginate($this->perPage);
        } else {
            $data = \App\Models\Equipment_license::where('id_section', session('id_section'))->search($this->search)
                ->orderBy($this->sortColumn, $this->sortDirection)
                ->paginate($this->perPage);
        }

        return view('livewire.equipment.index', [
            'data' => $data
        ]);
    }
}
