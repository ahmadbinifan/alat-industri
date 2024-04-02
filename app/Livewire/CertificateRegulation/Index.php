<?php

namespace App\Livewire\CertificateRegulation;

use Livewire\Component;
use App\Models\Regulasi_equipment as regulasi;
use Livewire\WithPagination;
use illuminate\Support\Facades\Storage;

class Index extends Component
{
    public $perPage = 10;
    public $search = '';
    public $sortDirection = 'ASC';
    public $sortColumn = 'regulation_no';
    use WithPagination;
    #[\Livewire\Attributes\On('refresh-list')]
    public function refresh()
    {
    }
    public function downloadFile($regulationId)
    {
        $regulation = regulasi::findOrFail($regulationId);
        $filePath = storage_path('app/' . $regulation->document_k3); // Sesuaikan dengan path file Anda
        return response()->download($filePath);
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
        $data = \App\Models\Regulasi_equipment::search($this->search)
            ->orderBy($this->sortColumn, $this->sortDirection)
            ->paginate($this->perPage);
        return view('livewire.certificate-regulation.index', ['data' => $data]);
    }
}
