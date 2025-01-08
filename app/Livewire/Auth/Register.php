<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Hash;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Register extends Component
{
    public $name, $email, $password, $password_confirmation;

    public function register()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        session()->flash('success', 'Registration successful. Please log in.');
        return redirect('/login');
    } 

    #[Layout('layouts.guest')] 
    public function render()
    {
        return view('livewire.auth.register');
    }
}
