<?php

namespace App\Livewire\Equipment;

use Livewire\Component;
use App\Models\Equipment_license;
use App\Models\approval_equipment_license;

class Approval extends Component
{
    public $id, $note, $estimated_cost;
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
            'fullname' => $eq->fullname,
            'id_section' => $eq->id_section,
            'note' => $this->note,
            'approved_at' => date('Y-m-d H:i:s'),
        ];

        switch ($eq->status) {
            case 'wait_dep':
                $this->storeApprove($data_approve);
                Equipment_license::where('id', $id)->update([
                    'status' => 'wait_admin_leg'
                ]);
                break;
            case 'wait_admin_legal':
                $this->storeApprove($data_approve);
                Equipment_license::where('id', $id)->update([
                    'status' => 'wait_dep_hrd',
                    'estimated_cost' => $this->estimated_cost
                ]);
                break;
            case 'wait_dep_hrd':
                $this->storeApprove($data_approve);
                Equipment_license::where('id', $id)->update([
                    'status' => 'wait_admin_hse',
                    'estimated_cost' => $this->estimated_cost
                ]);
                break;
            case 'wait_admin_hse':
                $this->storeApprove($data_approve);
                Equipment_license::where('id', $id)->update([
                    'status' => 'wait_dep_hse',
                    'estimated_cost' => $this->estimated_cost
                ]);
                break;
            case 'wait_dep_hse':
                $this->storeApprove($data_approve);
                Equipment_license::where('id', $id)->update([
                    'status' => 'wait_budgetcontroll',
                ]);
                break;
            case 'wait_budgetcontroll':
                $this->storeApprove($data_approve);
                Equipment_license::where('id', $id)->update([
                    'status' => 'in_progress_prpo',
                ]);
                break;
        }
    }
    public function render()
    {
        return view('livewire.equipment.approval');
    }
}
