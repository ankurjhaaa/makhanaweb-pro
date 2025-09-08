<?php

namespace App\Livewire\Public;

use Livewire\Component;

class CartCount extends Component
{
    public $count = 0;

    protected $listeners = ['cartUpdated' => 'refreshCount'];

    public function mount()
    {
        $this->count = session('cart_count', 0);
    }

    public function refreshCount($count = null)
    {
        // If count provided by event, use it. Otherwise fall back to session.
        if (is_null($count)) {
            $this->count = session('cart_count', 0);
        } else {
            $this->count = (int) $count;
            try {
                session()->put('cart_count', $this->count);
            } catch (\Exception $e) {
                // ignore session errors
            }
        }
    }

    public function render()
    {
        return view('livewire.public.cart-count');
    }
}
