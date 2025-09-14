<div>
    <div class="bg-white rounded-xl shadow-md p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
            <i class="fas fa-map-marker-alt text-brand-600 mr-2"></i> My Addresses
        </h1>

        {{-- Success / Error Messages --}}
        @if (session()->has('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg shadow-sm text-sm">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg shadow-sm text-sm">
                <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
            </div>
        @endif

        {{-- Add button --}}
        <div class="mb-6">
            <button wire:click="showAddForm" type="button"
                class="inline-flex items-center px-5 py-2.5 rounded-lg shadow-sm text-sm font-medium bg-gray-300 text-white bg-brand-600 hover:bg-brand-700 transition">
                <i class="fas fa-plus mr-2"></i> Add New Address
            </button>
        </div>

        {{-- Form --}}
        @if ($showForm)
            <form wire:submit.prevent="save" class="mb-6 space-y-4 bg-gray-50 p-5 rounded-lg border border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                        <select wire:model="type"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-brand-500 focus:border-brand-500">
                            <option value="">Select</option>
                            <option value="shipping">Shipping</option>
                            <option value="billing">Billing</option>
                        </select>
                        @error('type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                        <input type="text" wire:model="phone"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-brand-500 focus:border-brand-500">
                        @error('phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Address Line 1</label>
                    <input type="text" wire:model="address_line1"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-brand-500 focus:border-brand-500">
                    @error('address_line1') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Address Line 2</label>
                    <input type="text" wire:model="address_line2"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-brand-500 focus:border-brand-500">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">City</label>
                        <input type="text" wire:model="city"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-brand-500 focus:border-brand-500">
                        @error('city') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">State</label>
                        <input type="text" wire:model="state"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-brand-500 focus:border-brand-500">
                        @error('state') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Postal Code</label>
                        <input type="text" wire:model="postal_code"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-brand-500 focus:border-brand-500">
                        @error('postal_code') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                    <input type="text" wire:model="country"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-brand-500 focus:border-brand-500">
                    @error('country') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" wire:click="$set('showForm', false)"
                        class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 transition">Cancel</button>
                    <button type="submit"
                        class="px-4 py-2 bg-brand-600 text-white bg-green-950 rounded-lg hover:bg-brand-700 transition">{{ $isEditing ? 'Update' : 'Save' }}</button>
                </div>
            </form>
        @endif

        {{-- Address List --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($addresses as $address)
                <div class="border border-gray-200 rounded-xl p-6 hover:shadow-lg transition bg-white relative group">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="h-12 w-12 rounded-full bg-brand-100 flex items-center justify-center">
                                <i class="fas fa-home text-brand-600"></i>
                            </div>
                        </div>
                        <div class="ml-4 flex-1">
                            <h3 class="text-lg font-semibold text-gray-800 capitalize flex items-center">
                                {{ $address->type }}
                                <span
                                    class="ml-2 px-2 py-0.5 rounded-full text-xs font-medium {{ $address->type === 'shipping' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                                    {{ ucfirst($address->type) }}
                                </span>
                            </h3>
                            <p class="text-gray-500 mt-2 text-sm leading-relaxed">
                                {{ $address->address_line1 }}<br>
                                {{ $address->address_line2 ?? '' }}<br>
                                {{ $address->city }}, {{ $address->state }} - {{ $address->postal_code }}<br>
                                {{ $address->country }}<br>
                                <span class="font-medium">Phone:</span> {{ $address->phone ?? 'N/A' }}
                            </p>
                            <div class="mt-4 flex items-center space-x-4 opacity-0 group-hover:opacity-100 transition">
                                <button wire:click="edit({{ $address->id }})"
                                    class="text-sm text-brand-600 hover:text-brand-500 font-medium">
                                    <i class="fas fa-edit mr-1"></i> Edit
                                </button>
                                <button wire:click="delete({{ $address->id }})"
                                    class="text-sm text-red-600 hover:text-red-500 font-medium">
                                    <i class="fas fa-trash mr-1"></i> Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-gray-500">No addresses found. Please add one.</p>
            @endforelse
        </div>
    </div>
</div>