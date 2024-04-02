<?php

namespace App\Livewire\CertificateRegulation;

use Livewire\Component;
use App\Models\Regulasi_equipment;

class Delete extends Component
{
    public $id;
    #[\Livewire\Attributes\On('delete-mode')]
    public function deleteMode($id)
    {
        $this->id = $id;
    }
    public function delete()
    {
        $reg = Regulasi_equipment::destroy($this->id);
        if ($reg) {
            $this->dispatch('closeModal');
            $this->dispatch('swal', [
                'title' => 'Success',
                'text' => 'Certificate Regulation deleted successfully.',
                'icon' => 'success',
            ]);
            $this->dispatch('refresh-list');
        }
    }
    public function render()
    {
        return view('livewire.certificate-regulation.delete');
    }
}
