<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Login extends Component
{
    public $email, $password, $remember = false;

    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            return redirect()->intended('/home');
        }

        session()->flash('error', 'Invalid credentials.');
    }

    #[Layout('layouts.guest')] 
    public function render()
    {
        return view('livewire.auth.login');
    }
}
