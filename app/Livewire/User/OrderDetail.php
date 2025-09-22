<?php

namespace App\Livewire\User;

use App\Models\Order;
use Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
#[Layout('layouts.user')]

class OrderDetail extends Component
{
   
    public function render()
    {
        return view('livewire.user.order-detail');
    }
}
