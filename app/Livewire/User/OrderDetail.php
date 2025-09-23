<?php

namespace App\Livewire\User;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Review;
use Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.user')]
class OrderDetail extends Component
{
    public $order;
    public $hasDeliveredOrder = false;
    public $showReviewModal = false;
    public $rating;
    public $comment;
    public $currentItemId;


    public function mount($order_number)
    {
        $this->order = Order::with('orderItems.product')
            ->with(['shippingAddress', 'billingAddress']) // eager load
            ->where('order_number', $order_number)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $this->hasDeliveredOrder = $this->order->status === 'delivered';
    }
    public function openReviewModal($orderItemId)
    {
        $this->currentItemId = $orderItemId;
        $this->showReviewModal = true;
    }

    public function addReview()
    {
        $this->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:500',
        ]);

        $orderItem = OrderItem::findOrFail($this->currentItemId);

        Review::create([
            'product_id' => $orderItem->product_id,
            'user_id' => auth()->id(),
            'rating' => $this->rating,
            'comment' => $this->comment,
        ]);

        $this->closeReviewModal();
        session()->flash('success', 'Your review has been submitted successfully!');
    }

    public function closeReviewModal()
    {
        $this->showReviewModal = false;
        $this->reset(['rating', 'comment', 'currentItemId']);
    }


    public function render()
    {
        return view('livewire.user.order-detail', [
            'order' => $this->order,
            'hasDeliveredOrder' => $this->hasDeliveredOrder,
            'showReviewModal' => $this->showReviewModal, // ✅ Pass to blade
        ]);
    }
}
