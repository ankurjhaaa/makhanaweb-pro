<?php

namespace App\Http\Livewire;

use Livewire\Component;

class NewsletterSignup extends Component
{
    public $email = '';

    public function subscribe()
    {
        // Minimal placeholder logic; in a real app you'd validate and persist
        session()->flash('message', 'Thanks for subscribing!');
        $this->email = '';
    }

    public function render()
    {
        return view('livewire.newsletter-signup');
    }
}
