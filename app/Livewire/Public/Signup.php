<?php

namespace App\Livewire\Public;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

#[Layout('layouts.app')]
class Signup extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';

    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6|confirmed',
    ];

    public function register()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        Auth::login($user);

        session()->flash('success', 'Account created successfully!');
        return redirect()->to('/');
    }

    public function render()
    {
        return view('livewire.public.signup');
    }
}
