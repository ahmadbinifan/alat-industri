<?php

namespace App\Livewire\Equipment;

use Livewire\Component;
use App\Models\Equipment_license;
use App\Models\Regulasi_equipment;

class Detail extends Component
{

    public $id, $documentNo, $company, $fillingDate, $tagnumber, $idRegulation, $lastInspection,
        $documentRequirements, $ownerAsset, $locationAsset, $id_section, $status;

    #[\Livewire\Attributes\On('detail-mode')]
    public function detail($id)
    {
        $this->id = $id;
        try {
            $eq = Equipment_license::findOrFail($id);
            $reg = Regulasi_equipment::where('id', $eq->idRegulasi)->first();
            if (!$eq) {
                $this->dispatch('swal', [
                    'title' => 'Error',
                    'text' => 'Data not Found.',
                    'icon' => 'error',
                ]);
            } else {
                $this->documentNo = $eq->doc_no;
                $this->company = $eq->company;
                $this->fillingDate = date('Y-m-d', strtotime($eq->filing_date));
                $this->tagnumber = $eq->tag_number;
                $this->lastInspection = $eq->last_inspection;
                $this->ownerAsset = $eq->owner_asset;
                $this->locationAsset = $eq->location_asset;
                $this->documentRequirements = $eq->document_requirements;
                $this->idRegulation = $reg->regulation_no . " - " . $reg->regulation_desc;
                $this->status = $eq->status;
            }
        } catch (\Throwable $th) {
            $this->dispatch('swal', [
                'title' => 'Error',
                'text' => 'Data not Found.',
                'icon' => 'error',
            ]);
        }
    }
    public function openApprove($id)
    {
        $this->dispatch('openApprove', $id);
    }
    public function downloadFile()
    {
        $eq = Equipment_license::findOrFail($this->id);
        $filePath = storage_path('app/' . $eq->document_requirements); // Sesuaikan dengan path file Anda
        return response()->download($filePath);
    }
    public function close()
    {
        $this->reset();
    }
    public function render()
    {
        return view('livewire.equipment.detail');
    }
}
