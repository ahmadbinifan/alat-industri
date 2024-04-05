<?php

namespace App\Livewire\Equipment;

use Livewire\Component;
use App\Models\Equipment_license;
use App\Models\approval_equipment_license;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads;

class Approval extends Component
{
    use WithFileUploads;
    public $id, $note, $estimatedCost, $attachFromHSE = '';
    #[\Livewire\Attributes\On('openApprove')]
    public function showApproval($id)
    {
        $this->id = $id;
    }
    public function storeApprove($data)
    {
        return approval_equipment_license::create($data);
    }
    public function approved($id)
    {
        $eq = Equipment_license::where('id', $id)->first();
        $data_approve = [
            'doc_no' => $eq->doc_no,
            'fullname' => session('fullname'),
            'id_section' => $eq->id_section,
            'note' => $this->note,
            'approved_at' => date('Y-m-d H:i:s'),
        ];
        DB::beginTransaction();
        try {
            switch ($eq->status) {
                case 'wait_dep':
                    $this->storeApprove($data_approve);
                    Equipment_license::where('id', $id)->update([
                        'status' => 'wait_adm_legal'
                    ]);
                    break;
                case 'wait_adm_legal':
                    $this->storeApprove($data_approve);
                    Equipment_license::where('id', $id)->update([
                        'status' => 'wait_dep_hrd',
                        'estimated_cost' => $this->estimatedCost
                    ]);
                    break;
                case 'wait_dep_hrd':
                    $this->storeApprove($data_approve);
                    Equipment_license::where('id', $id)->update([
                        'status' => 'wait_adm_hse',
                        'estimated_cost' => $this->estimatedCost
                    ]);
                    break;
                case 'wait_adm_hse':
                    $this->storeApprove($data_approve);

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
                    break;
                case 'wait_dep_hse':
                    $this->storeApprove($data_approve);
                    Equipment_license::where('id', $id)->update([
                        'status' => 'wait_budgetcontrol',
                    ]);
                    break;
                case 'wait_budgetcontrol':
                    $this->storeApprove($data_approve);
                    Equipment_license::where('id', $id)->update([
                        'status' => 'in_progress_prpo',
                    ]);
                    break;
                case 'in_progress_prpo':
                    $this->storeApprove($data_approve);
                    Equipment_license::where('id', $id)->update([
                        'status' => 'license_running',
                    ]);
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
