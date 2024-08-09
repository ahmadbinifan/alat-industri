<?php

namespace App\Livewire\Equipment;

use Livewire\Component;
use App\Models\Equipment_license;
use App\Models\detail_equipment;
use App\Models\approval_equipment_license;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Mail;
use App\Mail\notificationEmail;

class Approval extends Component
{
    use WithFileUploads;
    public $id, $note, $estimatedCost, $attachFromHSE = '';
    #[\Livewire\Attributes\On('openApprove')]
    public function showApproval($id)
    {
        $this->id = $id;
    }
    public function storeApprove($eq)
    {
        $user = User::where('fullname', session('fullname'))->first();
        $data = [
            'doc_no' => $eq->doc_no,
            'fullname' => session('fullname'),
            'id_section' => $user->id_section,
            'note' => $this->note,
            'approved_at' => date('Y-m-d H:i:s'),
        ];
        return approval_equipment_license::create($data);
    }
    public function findPerson($id_position, $id_section)
    {
        return User::where('id_position', $id_position)->where('id_section', $id_section)->first();
    }
    public function approved($id)
    {
        $eq = Equipment_license::where('id', $id)->first();

        $bodyEmail = [
            'doc_no' => $eq->doc_no,
            'subject' => 'Need Approval License Equipment'
        ];
        $bodyEmail2 = [
            'doc_no' => $eq->doc_no,
            'subject' => 'License Equipment is Running'
        ];
        DB::beginTransaction();
        try {
            switch ($eq->status) {
                case 'wait_dep':
                    $this->storeApprove($eq);
                    Equipment_license::where('id', $id)->update([
                        'status' => 'wait_adm_legal'
                    ]);
                    $findPerson = $this->findPerson('ADMIN', 'LEG');
                    Mail::to($findPerson->email)->send(new notificationEmail($findPerson, $bodyEmail));
                    break;
                case 'wait_adm_legal':
                    $this->storeApprove($eq);
                    Equipment_license::where('id', $id)->update([
                        'status' => 'wait_dep_hrd',
                        'estimated_cost' => $this->estimatedCost
                    ]);
                    $findPerson = $this->findPerson('SECTHEAD', 'HRD');
                    Mail::to($findPerson->email)->send(new notificationEmail($findPerson, $bodyEmail));
                    break;
                case 'wait_dep_hrd':

                    $this->storeApprove($eq);
                    $detail =  detail_equipment::where('doc_no', $eq->doc_no)->first();
                    if ($detail->status == "close") {
                        Equipment_license::where('id', $id)->update([
                            'status' => 'license_running',
                        ]);
                        Equipment_license::where('doc_no', $eq->old_doc_no)->update([
                            'status' => 'closed',
                        ]);
                        $findPerson = $this->findPerson('ADMIN', $eq->id_section);
                        $allApproval = approval_equipment_license::where('doc_no', $eq->doc_no)->distinct()->get('fullname');
                        foreach ($allApproval as  $value) {
                            $user =  User::where('fullname', $value->fullname)->distinct('fullname')->first();
                            Mail::to($user->email)->send(new notificationEmail($user, $bodyEmail2));
                        }
                    }
                    if ($detail->status == "open") {
                        Equipment_license::where('id', $id)->update([
                            'status' => 'wait_adm_hse',
                        ]);
                        $findPerson = $this->findPerson('ADMIN', 'HSE');
                        Mail::to($findPerson->email)->send(new notificationEmail($findPerson, $bodyEmail));
                    }
                    break;
                case 'wait_adm_hse':
                    $this->storeApprove($eq);
                    if ($this->attachFromHSE) {
                        $path = $this->attachFromHSE->store('public/files');
                        Equipment_license::where('id', $id)->update([
                            'status' => 'wait_dep_hse',
                            'attachFromHSE' => $path,
                        ]);
                    } else {
                        Equipment_license::where('id', $id)->update([
                            'status' => 'wait_dep_hse',
                        ]);
                    }
                    $findPerson = $this->findPerson('SECTHEAD', 'HSE');
                    Mail::to($findPerson->email)->send(new notificationEmail($findPerson, $bodyEmail));
                    break;
                case 'wait_dep_hse':
                    $this->storeApprove($eq);
                    Equipment_license::where('id', $id)->update([
                        'status' => 'wait_budgetcontrol',
                    ]);
                    $findPerson = $this->findPerson('BUSINESS_CONTROL', 'BC');
                    Mail::to($findPerson->email)->send(new notificationEmail($findPerson, $bodyEmail));
                    break;
                case 'wait_budgetcontrol':
                    $this->storeApprove($eq);
                    Equipment_license::where('id', $id)->update([
                        'status' => 'in_progress_prpo',
                    ]);
                    $findPerson = $this->findPerson('ADMIN', 'LEG');
                    Mail::to($findPerson->email)->send(new notificationEmail($findPerson, $bodyEmail));
                    break;
                case 'in_progress_prpo':
                    $this->storeApprove($eq);
                    Equipment_license::where('id', $id)->update([
                        'status' => 'wait_dep_hrd',
                    ]);
                    $findPerson = $this->findPerson('SECTHEAD', 'HRD');
                    Mail::to($findPerson->email)->send(new notificationEmail($findPerson, $bodyEmail));
                    break;
            }
            $this->dispatch('closeModal');
            $this->dispatch('swal', [
                'title' => 'Success',
                'text' => 'Certificate Regulation created successfully.',
                'icon' => 'success',
            ]);
            $this->dispatch('refresh');
            DB::commit();
            return redirect()->route('equipment');
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('swal', [
                'title' => 'Error',
                'text' => $th . 'Certificate Regulation created failed.',
                'icon' => 'error',
            ]);
        }
    }
    public function render()
    {
        return view('livewire.equipment.approval');
    }
}
