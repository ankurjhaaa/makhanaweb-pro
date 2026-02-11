<div class="space-y-8">

    <!-- Header -->
    <div class="bg-white border border-gray-100 rounded-lg shadow-sm p-6">
        <h1 class="font-poppins text-2xl font-semibold text-gray-800 flex items-center">
            <i class="fas fa-map-marker-alt text-brand-600 mr-3"></i>
            My Addresses
        </h1>
    </div>


    <!-- Add Button -->
    <div>
        <button wire:click="showAddForm"
            class="inline-flex items-center px-5 py-2.5 bg-gray-600 text-white text-sm rounded-md hover:bg-brand-700 transition shadow-sm">
            <i class="fas fa-plus mr-2"></i>
            Add New Address
        </button>
    </div>


    <!-- Form -->
    @if ($showForm)
        <div class="bg-white border border-gray-100 rounded-lg shadow-sm p-6">
            <form wire:submit.prevent="save" class="space-y-5">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Type</label>
                        <select wire:model="type"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-brand-500 focus:border-brand-500">
                            <option value="">Select</option>
                            <option value="shipping">Shipping</option>
                            <option value="billing">Billing</option>
                        </select>
                        @error('type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Phone</label>
                        <input type="text" wire:model="phone"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-brand-500 focus:border-brand-500">
                        @error('phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                </div>

                <div>
                    <label class="block text-sm text-gray-600 mb-1">Address Line 1</label>
                    <input type="text" wire:model="address_line1"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-brand-500 focus:border-brand-500">
                </div>

                <div>
                    <label class="block text-sm text-gray-600 mb-1">Address Line 2</label>
                    <input type="text" wire:model="address_line2"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-brand-500 focus:border-brand-500">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                    <div>
                        <label class="block text-sm text-gray-600 mb-1">City</label>
                        <input type="text" wire:model="city"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-brand-500 focus:border-brand-500">
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600 mb-1">State</label>
                        <input type="text" wire:model="state"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-brand-500 focus:border-brand-500">
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Postal Code</label>
                        <input type="text" wire:model="postal_code"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-brand-500 focus:border-brand-500">
                    </div>

                </div>

                <div>
                    <label class="block text-sm text-gray-600 mb-1">Country</label>
                    <input type="text" wire:model="country"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-brand-500 focus:border-brand-500">
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" wire:click="$set('showForm', false)"
                        class="px-4 py-2 text-sm bg-gray-100 rounded-md hover:bg-gray-200 transition">
                        Cancel
                    </button>

                    <button type="submit"
                        class="px-4 py-2 text-sm bg-gray-600 text-white rounded-md hover:bg-gray-700 transition">
                        {{ $isEditing ? 'Update Address' : 'Save Address' }}
                    </button>
                </div>

            </form>
        </div>
    @endif


    <!-- Address List -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        @forelse($addresses as $address)

            <div class="bg-white border border-gray-100 rounded-lg shadow-sm p-6 relative">

                <div class="flex items-start gap-4">

                    <div class="h-10 w-10 rounded-full bg-brand-50 flex items-center justify-center">
                        <i class="fas fa-home text-brand-600 text-sm"></i>
                    </div>

                    <div class="flex-1">

                        <div class="flex items-center justify-between">

                            <h3 class="text-sm font-semibold text-gray-800 capitalize">
                                {{ ucfirst($address->type) }} Address
                            </h3>

                            <span class="text-xs px-2 py-0.5 rounded-full 
                                            {{ $address->type === 'shipping'
            ? 'bg-green-100 text-green-700'
            : 'bg-blue-100 text-blue-700' }}">
                                {{ ucfirst($address->type) }}
                            </span>

                        </div>

                        <div class="text-sm text-gray-500 mt-3 leading-relaxed">
                            {{ $address->address_line1 }} <br>
                            {{ $address->address_line2 }} <br>
                            {{ $address->city }}, {{ $address->state }} - {{ $address->postal_code }} <br>
                            {{ $address->country }} <br>
                            <span class="font-medium text-gray-700">
                                Phone:
                            </span>
                            {{ $address->phone ?? 'N/A' }}
                        </div>

                        <!-- Buttons (Always Visible — mobile safe) -->
                        <div class="mt-4 flex gap-4">

                            <button wire:click="edit({{ $address->id }})"
                                class="text-sm text-brand-600 hover:text-brand-500 font-medium">
                                Edit
                            </button>

                            <button wire:click="delete({{ $address->id }})"
                                class="text-sm text-red-600 hover:text-red-500 font-medium">
                                Delete
                            </button>

                        </div>

                    </div>

                </div>

            </div>

        @empty

            <div class="col-span-2 text-center py-10 text-gray-500">
                No addresses found. Please add one.
            </div>

        @endforelse

    </div>

</div>