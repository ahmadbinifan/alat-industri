<?php

namespace App\Livewire\equipment;

use Livewire\Component;
use Livewire\WithPagination;

class Equipment extends Component
{
    use WithPagination;
    public $perPage = 10;
    public $search = '';
    public $sortDirection = 'DESC';
    public $sortColumn = 'doc_no';
    #[\Livewire\Attributes\On('refresh-list')]
    public function refresh()
    {
    }
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
        $data = \App\Models\Equipment_license::where('id_section', session('id_section'))->search($this->search)
            ->orderBy($this->sortColumn, $this->sortDirection)
            ->paginate($this->perPage);
        return view('livewire.equipment.index', [
            'data' => $data
        ]);
    }
}
