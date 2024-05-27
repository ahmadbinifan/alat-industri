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
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Mail\notificationEmail;

class Detail extends Component
{

    public $id, $documentNo, $company, $fillingDate, $tagnumber, $descriptionAsset, $idRegulation, $lastInspection,
        $documentRequirements, $ownerAsset, $locationAsset, $id_section, $status, $attachFromHSE,
        $licenseNo, $licenseFrom, $issuedDateDocument, $lastLicenseDate, $reminderCheckingDate, $reminderTestingDate,
        $frequencyCheck, $estimatedCost, $reLicense, $frequencyTesting, $reLicenseTesting, $reminderSchedule, $statusDetail,
        $reminder_frequency;

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
                $this->id_section = $eq->id_section;
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
                $this->reminder_frequency = $detail->reminder_frequency;
                $this->frequencyCheck = $reg->check_frequency;
                $this->estimatedCost = "Rp." . number_format($eq->estimated_cost);
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
    public function refre($field)
    {
        switch ($field) {
            case 'Kurang dari 1 Bulan':
                $startIssued = Carbon::parse($this->lastLicenseDate);
                $newReminder = $startIssued->subMonths(1);
                return $this->reminderCheckingDate =  $newReminder->format('Y-m-d');
                break;
            case 'Kurang dari 2 Bulan':
                $startIssued = Carbon::parse($this->lastLicenseDate);
                $newReminder = $startIssued->subMonths(2);
                return $this->reminderCheckingDate =  $newReminder->format('Y-m-d');
                break;
            case 'Kurang dari 3 Bulan':
                $startIssued = Carbon::parse($this->lastLicenseDate);
                $newReminder = $startIssued->subMonths(3);
                return $this->reminderCheckingDate =  $newReminder->format('Y-m-d');
                break;
            case 'Kurang dari 4 Bulan':
                $startIssued = Carbon::parse($this->lastLicenseDate);
                $newReminder = $startIssued->subMonths(4);
                return $this->reminderCheckingDate =  $newReminder->format('Y-m-d');
                break;
            case 'Kurang dari 5 Bulan':
                $startIssued = Carbon::parse($this->lastLicenseDate);
                $newReminder = $startIssued->subMonths(5);
                return $this->reminderCheckingDate =  $newReminder->format('Y-m-d');
                break;
            case 'Kurang dari 6 Bulan':
                $startIssued = Carbon::parse($this->lastLicenseDate);
                $newReminder = $startIssued->subMonths(6);
                return $this->reminderCheckingDate =  $newReminder->format('Y-m-d');
                break;
        }
    }
    public function issuedDate($field)
    {
        $startIssued = Carbon::parse($field);
        switch ($this->frequencyCheck) {
            case 'sekali 6 bulan':
                $newExpired = $startIssued->addMonths(6);
                break;
            case 'sekali 1 tahun':
                $newExpired = $startIssued->addYears(1);
                break;
            case 'sekali 2 tahun':
                $newExpired = $startIssued->addYears(2);
                break;
            case 'sekali 3 tahun':
                $newExpired = $startIssued->addYears(3);
                break;
            case 'sekali 4 tahun':
                $newExpired = $startIssued->addYears(4);
                break;
            case 'sekali 5 tahun':
                $newExpired = $startIssued->addYears(5);
                break;
        }

        $this->lastLicenseDate = $newExpired->format('Y-m-d');
        $this->reminderTestingDate = $newExpired->format('Y-m-d');

        return [
            'lastLicenseDate' => $this->lastLicenseDate,
            'reminderTestingDate' => $this->reminderTestingDate
        ];
    }

    public function storeApprove()
    {
        $data = [
            'doc_no' => $this->documentNo,
            'fullname' => session('fullname'),
            'id_section' => session('id_section'),
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
            'reminder_frequency' => $this->reminder_frequency,
            'status' => 'close',
        ]);
        Equipment_license::where('doc_no', $this->documentNo)->update([
            'status' => 'wait_dep_hrd'
        ]);
        $this->storeApprove();

        $bodyEmails = [
            'doc_no' => $this->documentNo,
            'subject' => 'Need Approval License Equipment'
        ];
        $findPerson = $this->findPerson('SECTHEAD', 'HRD');
        Mail::to($findPerson->email)->send(new notificationEmail($findPerson, $bodyEmails));

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
    public function reqRenewal()
    {
        $eq = Equipment_license::where('doc_no', $this->documentNo)->first();
        $reg = Regulasi_equipment::where('id', $eq->idRegulasi)->first();
        $doc_no =  app('App\Livewire\equipment\Create')->generateDocNo();
        $data = [
            'doc_no' => $doc_no,
            'company' => $this->company,
            'filing_date' => date('Y-m-d'),
            'tag_number' => $this->tagnumber,
            'owner_asset' => $this->ownerAsset,
            'location_asset' => $this->locationAsset,
            'document_requirements' => $this->documentRequirements,
            'idRegulasi' => $reg->id,
            'last_inspection' => $this->lastInspection,
            'status' => "WAIT_DEP",
            'id_section' => $this->id_section,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        $data_approve = [
            'doc_no' => $doc_no,
            'fullname' => session('fullname'),
            'id_section' => session('id_section'),
            'note' => 'Generate Automatic Document.',
            'approved_at' => date('Y-m-d H:i:s'),
        ];
        $bodyEmail = [
            'doc_no' => $doc_no,
            'subject' => 'Need Approval License Equipment'
        ];

        try {
            Equipment_license::where('doc_no', $this->documentNo)->update([
                'status' => 'request_renewal',
                'new_doc_no' => $doc_no,
                'old_doc' => 1
            ]);
            $person = User::where('id_section', session('id_section'))->where('id_position', 'SECTHEAD')->first();
            detail_equipment::create([
                'doc_no' => $doc_no,
                'status' => 'open'
            ]);
            Equipment_license::create($data);
            approval_equipment_license::create($data_approve);
            Mail::to($person->email)->send(new notificationEmail($person, $bodyEmail));
            $this->dispatch('swal', [
                'title' => 'Success',
                'text' => 'Renewal License request successfully.',
                'icon' => 'success',
            ]);
            return redirect()->route('equipment');
        } catch (\Throwable $th) {
            $this->dispatch('swal', [
                'title' => 'Error',
                'text' => $th . 'Failed To Request Renewal.',
                'icon' => 'error',
            ]);
            $this->dispatch('refresh');
            return redirect()->route('equipment');
        }
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
    public function exportpdf()
    {
        $eq = Equipment_license::findOrFail($this->id);
        $masterEQ = masterEQ::where('tag_number', $eq->tag_number)->first();
        $reg = Regulasi_equipment::where('id', $eq->idRegulasi)->first();
        $detail = detail_equipment::where('doc_no', $eq->doc_no)->first();
        $approval = approval_equipment_license::where('doc_no', $eq->doc_no)->get();
        $logo = public_path('assets/images/brc.png');
        $data = [
            'head' => $eq,
            'detail' => $detail,
            'mastereq' => $masterEQ,
            'logo' => $logo,
            'reg' => $reg,
            'approval' => $approval,
        ];
        $filename = "equipment License - $eq->id.pdf";
        $pdf = PDF::loadView('livewire.equipment.pdf', $data)->setPaper('A4', 'landscape');
        return response()->streamDownload(function () use ($pdf) {
            echo  $pdf->stream();
        }, $filename);
    }
    public function render()
    {
        $id = $this->id;
        $list_approval = approval_equipment_license::where('doc_no', $this->documentNo)->get();
        return view('livewire.equipment.detail', [
            'list_approval' => $list_approval,
            'param' => $id
        ]);
    }
}
