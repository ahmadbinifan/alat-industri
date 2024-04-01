<?php

namespace App\Livewire\CertificateRegulation;

use Livewire\Component;
use App\Models\Regulasi_equipment as regulasi;
use Livewire\WithPagination;
use illuminate\Support\Facades\Storage;

class Index extends Component
{

    use WithPagination;
    #[\Livewire\Attributes\On('refresh-list')]
    public function refresh()
    {
    }
    public function downloadFile($regulationId)
    {
        $regulation = regulasi::findOrFail($regulationId);

        // Lakukan logika untuk mengunduh file disini, misalnya:
        $filePath = storage_path('app/' . $regulation->document_k3); // Sesuaikan dengan path file Anda
        return response()->download($filePath);

        // dd($regulasi);
        // if (Storage::disk('certificate-regulation')->exists($regulasi->document_k3)) {
        //     return Storage::download($regulasi->document_k3, $regulasi->regulation_desc);
        // }
    }
    public function render()
    {
        $data = \App\Models\Regulasi_equipment::latest()->paginate(5);
        return view('livewire.certificate-regulation.index', ['data' => $data]);
    }
}
