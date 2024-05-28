<?php

namespace App\Livewire\oldEquipment;

use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportEquipmentLicense;
use App\Models\Equipment_license;

class oldEquipment extends Component
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
            $data = \App\Models\Equipment_license::where('old_doc', '1')
                ->search($this->search)
                ->orderBy($this->sortColumn, $this->sortDirection)
                ->paginate($this->perPage);
        } elseif (session('id_section') == "HSE") {
            $data = \App\Models\Equipment_license::where('old_doc', '1')->search($this->search)
                ->orderBy($this->sortColumn, $this->sortDirection)
                ->paginate($this->perPage);
        } elseif (session('id_position') == "BUSINESS_CONTROL") {
            $data = \App\Models\Equipment_license::where('old_doc', '1')->search($this->search)
                ->orderBy($this->sortColumn, $this->sortDirection)
                ->paginate($this->perPage);
        } else {
            $data = \App\Models\Equipment_license::where('old_doc', '1')->where('id_section', session('id_section'))->search($this->search)
                ->orderBy($this->sortColumn, $this->sortDirection)
                ->paginate($this->perPage);
        }

        return view('livewire.oldEquipment.index', [
            'data' => $data
        ]);
    }
}
