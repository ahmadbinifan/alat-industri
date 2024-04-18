<?php

namespace App\Livewire;

use App\Models\detail_equipment;
use App\Models\Equipment_license;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class Home extends Component
{
    public function render()
    {
        $data = ['title' => 'Home'];
        $id_section = session('id_section');
        $id_position = session('id_position');
        if ($id_position == 'ADMIN') {
            if ($id_section == 'LEG' || $id_section == 'HSE') {
                $doc = detail_equipment::whereMonth('last_license_date', date('m'))->get();
                $docRunning = Equipment_license::where('status', 'license_running')->get();
                $docProgress = Equipment_license::whereNotIn('status', ['draft', 'reject', 'license_running'])->get();
            } else {
                $doc =  Equipment_license::join('detail_equipment_license', 'detail_equipment_license.doc_no', '=', 'equipment_license.doc_no')
                    ->select('*')
                    ->where('id_section', $id_section)
                    ->orderBy('equipment_license.updated_at', 'desc')
                    ->get();
                $docRunning = Equipment_license::where('status', 'license_running')->where('id_section', $id_section)->get();
                $docRunning = Equipment_license::where('status', 'license_running')->where('id_section', $id_section)->get();
                $docProgress = Equipment_license::where('id_section', $id_section)->whereNotIn('status', ['draft', 'reject', 'license_running'])->get();
            }
        }
        return view('livewire.home', [
            'data' => $data,
            'countDoc' => count($doc),
            'countRunning' => count($docRunning),
            'countProgress' => count($docProgress),
            'doc' => $doc,
        ]);
    }
}
