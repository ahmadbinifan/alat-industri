<?php

namespace App\Livewire\CertificateRegulation;

use App\Models\Regulasi_equipment;
use Livewire\Component;
use Livewire\Attributes\Rule;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;

class Create extends Component
{
    use WithFileUploads;
    #[Rule('required')]
    public $regulation_no = '';

    #[Rule('required')]
    public $regulation_desc = '';

    #[Rule('required')]
    public $category = '';

    #[Rule('required')]
    public $check_frequency = '';

    #[Rule('file|mimes:pdf,doc,docx|max:2048')]
    public $document_k3 = '';
    public $path;

    public function add()
    {
        $validated =  $this->validate();
        if ($this->document_k3) {
            $path = $this->document_k3->store('public/files');
            $validated['document_k3'] = $path;
        }
        DB::beginTransaction();
        try {
            $post = Regulasi_equipment::create($validated);
            $this->reset();
            $this->dispatch('closeModal');
            $this->dispatch('swal', [
                'title' => 'Success',
                'text' => 'Certificate Regulation created successfully.',
                'icon' => 'success',
            ]);
            $this->dispatch('refresh-list');
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('swal', [
                'title' => 'Error',
                'text' => $th . 'Certificate Regulation created failed.',
                'icon' => 'error',
            ]);
        }
    }
    public function close()
    {
        $this->reset();
        $this->document_k3 = null;
    }
    public function render()
    {
        return view('livewire.certificate-regulation.create');
    }
}
