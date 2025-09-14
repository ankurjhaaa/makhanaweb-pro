<?php

namespace App\Livewire\User;

use App\Models\Address;
use App\Models\Order;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.user')]
class Addresses extends Component
{
    public $addresses;

    // Add/Edit form properties
    public $addressId, $type, $address_line1, $address_line2, $city, $state, $country, $postal_code, $phone;

    public $showForm = false;
    public $isEditing = false;

    public function mount()
    {
        $this->loadAddresses();
    }

    public function loadAddresses()
    {
        $this->addresses = Address::where('user_id', Auth::id())->get();
    }

    public function showAddForm()
    {
        $this->resetForm();
        $this->showForm = true;
        $this->isEditing = false;
    }

    public function edit($id)
    {
        $address = Address::where('user_id', Auth::id())->findOrFail($id);
        $this->addressId = $address->id;
        $this->type = $address->type;
        $this->address_line1 = $address->address_line1;
        $this->address_line2 = $address->address_line2;
        $this->city = $address->city;
        $this->state = $address->state;
        $this->country = $address->country;
        $this->postal_code = $address->postal_code;
        $this->phone = $address->phone;

        $this->showForm = true;
        $this->isEditing = true;
    }

    public function save()
    {
        $this->validate([
            'type' => 'required|in:shipping,billing',
            'address_line1' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'phone' => 'nullable|string|max:20',
        ]);

        if ($this->isEditing && $this->addressId) {
            $address = Address::where('user_id', Auth::id())->findOrFail($this->addressId);
            $address->update($this->only(['type', 'address_line1', 'address_line2', 'city', 'state', 'country', 'postal_code', 'phone']));
        } else {
            Address::create(array_merge(
                $this->only(['type', 'address_line1', 'address_line2', 'city', 'state', 'country', 'postal_code', 'phone']),
                ['user_id' => Auth::id()]
            ));
        }

        $this->resetForm();
        $this->showForm = false;
        $this->loadAddresses();
        session()->flash('success', 'Address saved successfully.');
    }

    public function delete($id)
    {
        $address = Address::where('user_id', Auth::id())->findOrFail($id);

        // check if used in orders
        $isUsed = Order::where('billing_address_id', $id)
            ->orWhere('shipping_address_id', $id)
            ->exists();

        if ($isUsed) {
            session()->flash('error', 'This address is linked to orders and cannot be deleted.');
            return;
        }

        $address->delete();
        $this->loadAddresses();
        session()->flash('success', 'Address deleted successfully.');
    }

    private function resetForm()
    {
        $this->reset(['addressId', 'type', 'address_line1', 'address_line2', 'city', 'state', 'country', 'postal_code', 'phone']);
    }

    public function render()
    {
        return view('livewire.user.addresses');
    }
}
