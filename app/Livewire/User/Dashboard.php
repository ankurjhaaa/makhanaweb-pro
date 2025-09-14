<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Order;
use App\Models\Wishlist;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.user')]
class Dashboard extends Component
{
    public $recentOrders;
    public $totalSpent;
    public $wishlistCount;
    public $addressesCount;

    public function mount()
    {
        $user = Auth::user();

        // Recent orders count (last 30 days)
        $this->recentOrders = Order::where('user_id', $user->id)
            ->where('created_at', '>=', now()->subDays(30))
            ->count();

        // Total spent
        $this->totalSpent = Order::where('user_id', $user->id)
            ->where('status', 'completed') // only completed orders
            ->sum('total_amount');

        // Wishlist count
        $this->wishlistCount = 10;

        // Saved addresses
        $this->addressesCount = Address::where('user_id', $user->id)->count();
    }

    public function render()
    {
        return view('livewire.user.dashboard');
    }
}
