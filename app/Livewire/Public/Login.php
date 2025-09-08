<?php

namespace App\Livewire\Public;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

#[Layout('layouts.app')]
class Login extends Component
{
    public $email = '';
    public $password = '';
    public $remember = false;
    public $showPassword = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:6',
    ];

    protected $messages = [
        'email.required' => 'Email address is required',
        'email.email' => 'Please enter a valid email address',
        'password.required' => 'Password is required',
        'password.min' => 'Password must be at least 6 characters',
    ];

    public function mount()
    {
        // Redirect if already authenticated
        if (Auth::check()) {
            return redirect()->intended('/');
        }
    }

    public function login()
    {
        $this->validate();

        $credentials = [
            'email' => $this->email,
            'password' => $this->password,
        ];

        if (Auth::attempt($credentials, $this->remember)) {
            session()->regenerate();
            session()->flash('success', 'Welcome back! You have been logged in successfully.');
            
            return redirect()->intended('/');
        }

        $this->addError('email', 'The provided credentials do not match our records.');
    }

    public function togglePasswordVisibility()
    {
        $this->showPassword = !$this->showPassword;
    }

    public function redirectToGoogle()
    {
        return redirect()->route('auth.google');
    }

    public function render()
    {
        return view('livewire.public.login');
    }
}
