<?php

namespace App\Livewire\Equipment;

use App\Jobs\reminderLicense;
use App\Livewire\equipment\Equipment;
use App\Models\approval_equipment_license;
use Livewire\Component;
use App\Models\Equipment_license;
use App\Models\detail_equipment;
use App\Models\Regulasi_equipment;
use App\Models\equipment as masterEQ;
use App\Models\User;
use Carbon\Carbon;

class Detail extends Component
{

    public $id, $documentNo, $company, $fillingDate, $tagnumber, $descriptionAsset, $idRegulation, $lastInspection,
        $documentRequirements, $ownerAsset, $locationAsset, $id_section, $status, $attachFromHSE,
        $licenseNo, $licenseFrom, $issuedDateDocument, $lastLicenseDate, $reminderCheckingDate, $reminderTestingDate,
        $frequencyCheck, $reLicense, $frequencyTesting, $reLicenseTesting, $reminderSchedule, $statusDetail;

    #[\Livewire\Attributes\On('detail')]
    public function detail($id)
    {
        $this->id = $id;
        try {
            $eq = Equipment_license::findOrFail($id);
            $detail = detail_equipment::where('doc_no', $eq->doc_no)->first();
            $reg = Regulasi_equipment::where('id', $eq->idRegulasi)->first();
            $master_equipment = masterEQ::where('tag_number', $eq->tag_number)->first();

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
                $this->attachFromHSE = $eq->attachFromHSE;
                $this->licenseNo = $detail->license_no;
                $this->licenseFrom = $detail->license_from;
                $this->issuedDateDocument = $detail->issued_date_document;
                $this->lastLicenseDate = $detail->last_license_date;
                $this->reminderCheckingDate = $detail->reminder_checking_date;
                $this->reminderTestingDate = $detail->reminder_testing_date;
                $this->frequencyCheck = $detail->frequency_check;
                $this->reLicense = $detail->re_license;
                $this->frequencyTesting = $detail->frequency_testing;
                $this->reLicenseTesting = $detail->re_license_testing;
                $this->reminderSchedule = $detail->reminderSchedule;
                $this->statusDetail = $detail->status;
                $this->descriptionAsset = $master_equipment->description;
            }
            // dd($this->descriptionAsset);
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
            'note' => 'Updated License No. , reminder notification, etc..',
            'approved_at' => date('Y-m-d H:i:s'),
        ];
        return approval_equipment_license::create($data);
    }
    public function updatePRPO()
    {
        detail_equipment::where('doc_no', $this->documentNo)->update([
            'license_no' => $this->licenseNo,
            'license_from' => $this->licenseFrom,
            'issued_date_document' => $this->issuedDateDocument,
            'last_license_date' => $this->lastLicenseDate,
            'reminder_checking_date' => $this->reminderCheckingDate,
            'reminder_testing_date' => $this->reminderTestingDate,
            'frequency_check' => $this->frequencyCheck,
            're_license' => $this->reLicense,
            'frequency_testing' => $this->frequencyTesting,
            're_license_testing' => $this->reLicenseTesting,
            'status' => 'close',
        ]);
        Equipment_license::where('doc_no', $this->documentNo)->update([
            'status' => 'wait_dep_hrd'
        ]);
        $this->storeApprove();
        $eq = Equipment_license::where('doc_no', $this->documentNo)->first();
        $detail = detail_equipment::where('doc_no', $this->documentNo)->first();
        $person = User::where('id_section', $eq->id_section)->where('id_position', 'ADMIN')->first();
        $bodyEmail = [
            'doc_no' => $eq->doc_no,
            'subject' => 'Need Re License Equipment'
        ];
        if ($this->reminderSchedule == 'yes') {
            $originalSchedule = Carbon::parse($detail->reminder_checking_date);
            $newSchedule = $originalSchedule->copy()->setHour(10)->setMinute(25)->setSecond(0);
            reminderLicense::dispatch($person, $bodyEmail)->delay($newSchedule);
        }

        $this->dispatch('closeModal');
        $this->dispatch('swal', [
            'title' => 'Success',
            'text' => 'Certificate Regulation created successfully.',
            'icon' => 'success',
        ]);
        return redirect()->route('equipment');
    }
    public function reminderScheduleUpdate()
    {
        detail_equipment::where('doc_no', $this->documentNo)->update([
            'reminderSchedule' => $this->reminderSchedule
        ]);
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
    public function downloadFileHSE()
    {
        $eq = Equipment_license::findOrFail($this->id);
        $filePath = storage_path('app/' . $eq->attachFromHSE); // Sesuaikan dengan path file Anda
        return response()->download($filePath);
    }
    public function close()
    {
        $this->reset();
    }
    public function render()
    {
        $list_approval = approval_equipment_license::where('doc_no', $this->documentNo)->get();
        return view('livewire.equipment.detail', [
            'list_approval' => $list_approval
        ]);
    }
}
