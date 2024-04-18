<?php

namespace App\Livewire\CertificateRegulation;

use Livewire\Component;
use App\Models\Regulasi_equipment;
use Livewire\WithFileUploads;

class Update extends Component
{
    use WithFileUploads;
    public $reg, $id, $regulationNo, $regulationDesc, $category, $documentK3, $checkFrequency;
    protected $casts = [
        'checkFrequency' => 'date:Y-m-d',
    ];
    #[\Livewire\Attributes\On('edit-mode')]
    public function edit($id)
    {
        try {
            $reg = Regulasi_equipment::findOrFail($id);
            if (!$reg) {
                $this->dispatch('swal', [
                    'title' => 'Error',
                    'text' => 'Data not Found.',
                    'icon' => 'error',
                ]);
            } else {
                $this->id = $reg->id;
                $this->regulationNo = $reg->regulation_no;
                $this->regulationDesc = $reg->regulation_desc;
                $this->category = $reg->category;
                $this->documentK3 = $reg->document_k3;
                $this->checkFrequency = date('Y-m-d', strtotime($reg->check_frequency));
            }
        } catch (\Throwable $th) {
            $this->dispatch('swal', [
                'title' => 'Error',
                'text' => 'Data not Found.',
                'icon' => 'error',
            ]);
        }
    }
    public function update()
    {
        try {
            if ($this->documentK3) {
                $this->documentK3 = $this->documentK3->store('public/files');
                Regulasi_equipment::whereId($this->id)->update([
                    'regulation_no' => $this->regulationNo,
                    'regulation_desc' => $this->regulationDesc,
                    'category' => $this->category,
                    'document_k3' => $this->documentK3,
                    'check_frequency' => $this->checkFrequency,
                ]);
            } else {
                Regulasi_equipment::whereId($this->id)->update([
                    'regulation_no' => $this->regulationNo,
                    'regulation_desc' => $this->regulationDesc,
                    'category' => $this->category,
                    'check_frequency' => $this->checkFrequency,
                ]);
            }
            $this->reset();
            $this->dispatch('closeModal');
            $this->dispatch('swal', [
                'title' => 'Success',
                'text' => 'Certificate Regulation updated successfully.',
                'icon' => 'success',
            ]);
            $this->dispatch('refresh-list');
        } catch (\Throwable $th) {
            $this->dispatch('swal', [
                'title' => 'Error',
                'text' => $th . 'Certificate Regulation updated failed.',
                'icon' => 'error',
            ]);
        }
    }
    public function close()
    {
        $this->reset();
    }
    public function render()
    {
        return view('livewire.certificate-regulation.update');
    }
}
