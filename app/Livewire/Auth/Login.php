<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

#[Layout('layouts.master-auth')]
class Login extends Component
{
    #[Validate('required')]
    public $username = '';
    #[Validate('required')]
    public $password = '';

    public function login()
    {
        $this->validate();
        $user = User::where('username', $this->username)->where('password', md5($this->password))->first();
        if ($user) {
            Auth::login($user);
            redirect(route('home'));
        } else {
            redirect(route('login'));
        }
    }
    public function render()
    {
        return view('livewire.auth.login');
    }
}
