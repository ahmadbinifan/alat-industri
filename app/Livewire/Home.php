<?php

namespace App\Livewire;

use Livewire\Component;

class Home extends Component
{
    public function render()
    {
        $data = ['title' => 'Home'];
        // session(['username' => 'Nama Pengguna']);
        return view('livewire.home', [
            'data' => $data
        ]);
    }
}
