<?php

namespace App\Livewire\equipment;

use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportEquipmentLicense;
use App\Models\Equipment_license;

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
    public $detailRow = false;
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
    public function exportExcel()
    {
        return Excel::download(new ExportEquipmentLicense, 'equipment_license.xlsx');
    }
    public function render()
    {
        if (session('id_section') == "LEG" || session('id_section') == "HRD") {
            $data = \App\Models\Equipment_license::with('equipment')->where('status', 'wait_adm_legal')
                ->where('old_doc', '0')
                ->orWhere('status', 'wait_dep_hrd')
                ->orWhere('status', 'in_progress_prpo')
                ->orWhere('status', 'license_running')
                ->orWhere('status', 'need_re_license')
                ->search($this->search)
                ->orderBy($this->sortColumn, $this->sortDirection)
                ->paginate($this->perPage);
        } elseif (session('id_section') == "HSE") {
            $data = \App\Models\Equipment_license::with('equipment')->where('status', 'wait_adm_hse')
                ->orWhere('status', 'wait_dep_hse')
                ->where('old_doc', '0')
                ->search($this->search)
                ->orderBy($this->sortColumn, $this->sortDirection)
                ->paginate($this->perPage);
        } elseif (session('id_position') == "BUSINESS_CONTROL") {
            $data = \App\Models\Equipment_license::with('equipment')->where('status', 'wait_budgetcontrol')
                ->where('old_doc', '0')
                ->search($this->search)
                ->orderBy($this->sortColumn, $this->sortDirection)
                ->paginate($this->perPage);
        } else {
            $data = \App\Models\Equipment_license::with('equipment')->where('id_section', session('id_section'))
                ->where('old_doc', '0')
                ->search($this->search)
                ->orderBy($this->sortColumn, $this->sortDirection)
                ->paginate($this->perPage);
        }
        return view('livewire.equipment.index', [
            'data' => $data
        ]);
    }
}
