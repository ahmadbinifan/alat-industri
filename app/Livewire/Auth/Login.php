<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Session;

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
            Session::put([
                'fullname' => $user->fullname,
                'email' => $user->email,
                'id_section' => $user->id_section,
                'id_division' => $user->id_division,
                'department' => $user->department,
                'group_section' => $user->group_section,
                'id_position' => $user->id_position,
            ]);
            Session::flash('success', 'Login Successfull');
            redirect(route('home'));
        } else {
            Session::flash('fail', 'Wrong Username/Password');
            redirect(route('login'));
        }
    }
    public function render()
    {
        return view('livewire.auth.login');
    }
}
