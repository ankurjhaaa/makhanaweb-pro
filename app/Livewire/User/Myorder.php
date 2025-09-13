<?php

namespace App\Livewire\User;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.user')]
class Myorder extends Component
{
    use WithPagination;
    
    public $filterStatus = 'all';
    public $searchQuery = '';
    public $dateRange = '';
    
    protected $queryString = [
        'filterStatus' => ['except' => 'all'],
        'searchQuery' => ['except' => ''],
        'dateRange' => ['except' => ''],
    ];
    
    public function render()
    {
        $userId = Auth::id();
        
        $ordersQuery = Order::where('user_id', $userId)
            ->with(['orderItems.product', 'coupon'])
            ->latest();
        
        // Apply status filter
        if ($this->filterStatus !== 'all') {
            $ordersQuery->where('status', $this->filterStatus);
        }
        
        // Apply search query on order number
        if (!empty($this->searchQuery)) {
            $ordersQuery->where('order_number', 'like', '%' . $this->searchQuery . '%');
        }
        
        // Apply date range filter
        if (!empty($this->dateRange)) {
            $dates = explode(' - ', $this->dateRange);
            if (count($dates) === 2) {
                $startDate = date('Y-m-d', strtotime($dates[0]));
                $endDate = date('Y-m-d', strtotime($dates[1]));
                $ordersQuery->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
            }
        }
        
        $orders = $ordersQuery->paginate(10);
        
        return view('livewire.user.myorder', [
            'orders' => $orders,
            'orderStatuses' => [
                'all' => 'All Orders',
                'pending' => 'Pending',
                'processing' => 'Processing',
                'shipped' => 'Shipped',
                'delivered' => 'Delivered',
                'cancelled' => 'Cancelled'
            ]
        ]);
    }
    
    public function clearFilters()
    {
        $this->filterStatus = 'all';
        $this->searchQuery = '';
        $this->dateRange = '';
    }
    
    public function cancelOrder($orderId)
    {
        $order = Order::where('id', $orderId)
            ->where('user_id', Auth::id())
            ->first();
            
        if ($order && ($order->status === 'pending' || $order->status === 'processing')) {
            $order->status = 'cancelled';
            $order->save();
            
            $this->dispatch('alert', [
                'type' => 'success',
                'message' => 'Order has been cancelled successfully!'
            ]);
        } else {
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => 'This order cannot be cancelled.'
            ]);
        }
    }
}
