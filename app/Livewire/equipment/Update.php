<?php

namespace App\Livewire\Equipment;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Rule;
use App\Models\Equipment_license;
use \App\Models\company;
use \App\Models\approval_equipment_license;
use \App\Models\equipment;
use \App\Models\User;
use \App\Models\Regulasi_equipment;
use \App\Models\detail_equipment;
use Illuminate\Support\Facades\Mail;
use App\Mail\notificationEmail;

class Update extends Component
{
    use WithFileUploads;
    public $documentNo;
    #[Rule('required')]
    public $company;
    #[Rule('required')]
    public $fillingDate;
    #[Rule('required')]
    public $tagnumber;
    #[Rule('required')]
    public $idRegulation;

    #[Rule('required')]
    public $lastInspection;
    #[Rule('file|mimes:pdf,doc,docx|max:2048')]
    public $documentRequirements;
    #[Rule('file|mimes:pdf,doc,docx|max:2048')]
    public $documentRequirementsU;

    public $ownerAsset;
    public $locationAsset;
    public $id_section = '';
    public $showDr = false;
    public $showDel = false;

    #[\Livewire\Attributes\On('edit-mode')]

    public function edit($id)
    {
        try {
            $eq = Equipment_license::findOrFail($id);
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
                $this->idRegulation = $eq->idRegulasi;
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
    public function storeApprove()
    {
        $data = [
            'doc_no' => $this->documentNo,
            'fullname' => session('fullname'),
            'id_section' => $this->id_section,
            'note' => 'Created Document.',
            'approved_at' => date('Y-m-d H:i:s'),
        ];
        return approval_equipment_license::create($data);
    }
    public function update()
    {
        $person = User::where('id_section', session('id_section'))->where('id_position', 'SECTHEAD')->first();
        $bodyEmail = [
            'doc_no' => $this->documentNo,
            'subject' => 'Need Approval License Equipment'
        ];
        try {
            if ($this->documentRequirementsU) {
                $path = $this->documentRequirementsU->store('public/files');
                Equipment_license::where('doc_no', $this->documentNo)->update([
                    'doc_no' => $this->documentNo,
                    'company' => $this->company,
                    'filing_date' => $this->fillingDate,
                    'tag_number' => $this->tagnumber,
                    'owner_asset' => $this->ownerAsset,
                    'location_asset' => $this->locationAsset,
                    'idRegulasi' => $this->idRegulation,
                    'last_inspection' => $this->lastInspection,
                    'document_requirements' => $path,
                    'status' => 'wait_dep'
                ]);
            } else {
                Equipment_license::where('doc_no', $this->documentNo)->update([
                    'doc_no' => $this->documentNo,
                    'company' => $this->company,
                    'filing_date' => $this->fillingDate,
                    'tag_number' => $this->tagnumber,
                    'owner_asset' => $this->ownerAsset,
                    'location_asset' => $this->locationAsset,
                    'idRegulasi' => $this->idRegulation,
                    'last_inspection' => $this->lastInspection,
                    'status' => 'wait_dep'
                ]);
            }
            detail_equipment::create([
                'doc_no' => $this->documentNo
            ]);
            $this->storeApprove();
            Mail::to($person->email)->send(new notificationEmail($person, $bodyEmail));
            $this->dispatch('closeModal');
            $this->dispatch('swal', [
                'title' => 'Success',
                'text' => 'Equipment License updated successfully.',
                'icon' => 'success',
            ]);
            return redirect()->route('equipment');
        } catch (\Throwable $th) {
            $this->dispatch('swal', [
                'title' => 'Success',
                'text' => 'Equipment License created error.',
                'icon' => 'error',
            ]);
        }
    }
    public function draft()
    {
        if ($this->documentRequirements) {
            $path = $this->documentRequirements->store('public/files');
            $validated['documentRequirements'] = $path;
            Equipment_license::where('doc_no', $this->documentNo)->update([
                'doc_no' => $this->documentNo,
                'company' => $this->company,
                'filing_date' => $this->fillingDate,
                'tag_number' => $this->tagnumber,
                'owner_asset' => $this->ownerAsset,
                'location_asset' => $this->locationAsset,
                'idRegulasi' => $this->idRegulation,
                'last_inspection' => $this->lastInspection,
                'document_requirements' => $path,
                'status' => 'draft',
            ]);
        } else {
            Equipment_license::where('doc_no', $this->documentNo)->update([
                'doc_no' => $this->documentNo,
                'company' => $this->company,
                'filing_date' => $this->fillingDate,
                'tag_number' => $this->tagnumber,
                'owner_asset' => $this->ownerAsset,
                'location_asset' => $this->locationAsset,
                'idRegulasi' => $this->idRegulation,
                'last_inspection' => $this->lastInspection,
                'status' => 'draft',
            ]);
        }
        $this->reset();
        $this->dispatch('closeModal');
        $this->dispatch('swal', [
            'title' => 'Success',
            'text' => 'Equipment License is Draft.',
            'icon' => 'warning',
        ]);
        $this->dispatch('refresh');
        return redirect()->route('equipment');
    }
    public function close()
    {
        $this->reset();
    }
    public function updatedTagnumber()
    {
        $equipment = equipment::where('tag_number', $this->tagnumber)->first();
        $this->ownerAsset = $equipment->owner1;
        $this->locationAsset = $equipment->location;
    }
    public function removeAttachments()
    {
        $eq =   Equipment_license::where('document_requirements', $this->documentRequirements)->update([
            'document_requirements' => null
        ]);
        $this->documentRequirements = null;
    }
    public function render()
    {
        $companies = company::get();
        $tag_number = equipment::get();
        $regulation = Regulasi_equipment::get();
        return view('livewire.equipment.update', [
            'companies' => $companies,
            'tag_number' => $tag_number,
            'regulation' => $regulation
        ]);
    }
}
