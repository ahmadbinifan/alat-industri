<?php

namespace App\Livewire\Equipment;

use App\Mail\notificationEmail;
use Livewire\Component;
use App\Models\Equipment_license;
use \App\Models\company;
use \App\Models\equipment;
use \App\Models\Regulasi_equipment;
use \App\Models\detail_equipment;
use \App\Models\approval_equipment_license;
use App\Models\User;
use Livewire\WithFileUploads;
use Livewire\Attributes\Rule;
use Illuminate\Support\Facades\Mail;
use Illuminate\support\Facades\DB;

class Create extends Component
{
    use WithFileUploads;
    public $documentNo;
    #[Rule('required')]
    public $company;
    #[Rule('required')]
    public $fillingDate;
    #[Rule('required')]
    public $tagnumber = null;
    #[Rule('required')]
    public $idRegulation;

    #[Rule('required')]
    public $lastInspection;
    #[Rule('file|mimes:pdf,doc,docx|max:2048')]
    public $documentRequirements;

    public $ownerAsset;
    public $locationAsset;
    public $id_section = '';

    public function draft()
    {
        $id_section = session('id_section');
        if ($this->documentRequirements) {
            $path = $this->documentRequirements->store('public/files');
            // $validated['documentRequirements'] = $path;
            Equipment_license::create([
                'doc_no' => $this->documentNo,
                'company' => $this->company,
                'filing_date' => $this->fillingDate,
                'tag_number' => $this->tagnumber,
                'owner_asset' => $this->ownerAsset,
                'location_asset' => $this->locationAsset,
                'idRegulasi' => $this->idRegulation,
                'last_inspection' => $this->lastInspection,
                'document_requirements' => $path,
                'id_section' => $id_section,
                'status' => 'draft',
                'old_doc' => '0',
            ]);
            detail_equipment::create([
                'doc_no' => $this->documentNo,
                'status' => 'open'
            ]);
        } else {
            Equipment_license::create([
                'doc_no' => $this->documentNo,
                'company' => $this->company,
                'filing_date' => $this->fillingDate,
                'tag_number' => $this->tagnumber,
                'owner_asset' => $this->ownerAsset,
                'location_asset' => $this->locationAsset,
                'idRegulasi' => $this->idRegulation,
                'last_inspection' => $this->lastInspection,
                'id_section' => $id_section,
                'status' => 'draft',
                'old_doc' => '0',
            ]);
            detail_equipment::create([
                'doc_no' => $this->documentNo,
                'status' => 'open'
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
    public function add()
    {
        $id_section = session('id_section');
        $person = User::where('id_section', session('id_section'))->where('id_position', 'SECTHEAD')->first();
        $bodyEmail = [
            'doc_no' => $this->documentNo,
            'subject' => 'Need Approval License Equipment'
        ];
        if ($this->documentRequirements) {
            $path = $this->documentRequirements->store('public/files');
            // $validated['documentRequirements'] = $path;
            Equipment_license::create([
                'doc_no' => $this->documentNo,
                'company' => $this->company,
                'filing_date' => $this->fillingDate,
                'tag_number' => $this->tagnumber,
                'owner_asset' => $this->ownerAsset,
                'location_asset' => $this->locationAsset,
                'idRegulasi' => $this->idRegulation,
                'last_inspection' => $this->lastInspection,
                'document_requirements' => $path,
                'id_section' => $id_section,
                'old_doc' => '0',
            ]);
        } else {
            Equipment_license::create([
                'doc_no' => $this->documentNo,
                'company' => $this->company,
                'filing_date' => $this->fillingDate,
                'tag_number' => $this->tagnumber,
                'owner_asset' => $this->ownerAsset,
                'location_asset' => $this->locationAsset,
                'idRegulasi' => $this->idRegulation,
                'last_inspection' => $this->lastInspection,
                'id_section' => $id_section,
                'old_doc' => '0',
            ]);
        }
        $this->storeApprove();
        detail_equipment::create([
            'doc_no' => $this->documentNo
        ]);
        Mail::to($person->email)->send(new notificationEmail($person, $bodyEmail));
        $this->reset();
        $this->dispatch('closeModal');
        $this->dispatch('swal', [
            'title' => 'Success',
            'text' => 'Equipment License created successfully.',
            'icon' => 'success',
        ]);
        $this->dispatch('refresh');
    }
    public function updatedTagnumber()
    {
        $equipment = equipment::where('tag_number', $this->tagnumber)->first();
        $this->ownerAsset = $equipment->owner1;
        $this->locationAsset = $equipment->location;
    }
    public function generateDocNo()
    {
        $id = session('id_section');

        // $max = Equipment_license::where('doc_no', 'like', "EL/{$id}-%/" . date('Y') . "/")
        //     ->max(\DB::raw("CAST(RIGHT(doc_no, 3) AS SIGNED)"));
        $max = Equipment_license::where('doc_no', 'like', "EL/{$id}-" . date('Y') . "/%")
            ->max(\DB::raw("CAST(SUBSTRING(doc_no, LENGTH(doc_no) - 2) AS SIGNED)"));
        $max = $max ? $max + 1 : 1;
        $max = sprintf("%03d", $max);
        $format = "EL/{$id}-" . date('Y') . "/{$max}";
        return $format;
    }

    public function close()
    {
        $this->reset();
    }
    public function render()
    {
        $this->fillingDate = date('Y-m-d');
        $this->documentNo = $this->generateDocNo();
        $companies = company::get();
        $tag_number = equipment::get();
        $regulation = Regulasi_equipment::get();
        return view('livewire.equipment.create', [
            'companies' => $companies,
            'tag_number' => $tag_number,
            'regulation' => $regulation
        ]);
    }
}
