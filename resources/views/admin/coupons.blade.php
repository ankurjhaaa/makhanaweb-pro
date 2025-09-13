@extends('admin.layout')

@section('title', 'Coupons Page')

@section('content')
    <div class="pt-8 pb-4">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Discount Coupons</h1>
                <p class="text-gray-600 mt-1">Create and manage promotional offers</p>
            </div>
            
            <div class="mt-4 md:mt-0">
                <button id="openCouponModal" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md shadow flex items-center gap-2">
                    <i class="fas fa-plus"></i>
                    <span>Add Coupon</span>
                </button>
            </div>
        </div>

        <div class="bg-white shadow-sm border border-gray-200 rounded-xl overflow-hidden">
            <div class="p-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 gap-4">
                    <h2 class="text-lg font-semibold text-gray-800">All Coupons</h2>
                    
                    <div class="relative">
                        <input type="text" placeholder="Search coupons..." 
                            class="py-2 pl-10 pr-4 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full text-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Discount Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Discount Value</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Min Order Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Max Discount Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valid From</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valid Until</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usage Limit</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Used Count</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($coupons as $coupon)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap font-medium">{{ $coupon->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-mono font-medium bg-gray-100 px-2 py-1 rounded">{{ $coupon->code }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap capitalize">
                                @if($coupon->discount_type == 'percentage')
                                    <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">
                                        {{ $coupon->discount_type }}
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs bg-purple-100 text-purple-800 rounded-full">
                                        {{ $coupon->discount_type }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium">
                                @if($coupon->discount_type == 'percentage')
                                    {{ $coupon->discount_value }}%
                                @else
                                    ₹{{ $coupon->discount_value }}
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $coupon->min_order_amount ? '₹'.$coupon->min_order_amount : '—' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $coupon->max_discount_amount ? '₹'.$coupon->max_discount_amount : '—' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($coupon->valid_from)->format('d M Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($coupon->valid_until)->format('d M Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $coupon->usage_limit ?: 'Unlimited' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $coupon->used_count }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($coupon->status == 'active')
                                    <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Active</span>
                                @else
                                    <span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded-full">Inactive</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-3">
                                    <button
                                        onclick="document.getElementById('editModal-{{ $coupon->id }}').classList.remove('hidden')"
                                        class="text-blue-600 hover:text-blue-900" title="Edit Coupon">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('deleteCoupon', $coupon->id) }}" method="post" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure you want to delete this coupon?')"
                                            class="text-red-600 hover:text-red-900" title="Delete Coupon">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        {{-- Edit Modal --}}
                        <div id="editModal-{{ $coupon->id }}" class="hidden">
                            <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm flex justify-center items-center z-50 p-4">
                                <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg relative">
                                    <div class="px-6 py-4 border-b border-gray-200">
                                        <div class="flex items-center justify-between">
                                            <h2 class="text-xl font-bold text-gray-800">Edit Coupon</h2>
                                            <button
                                                onclick="document.getElementById('editModal-{{ $coupon->id }}').classList.add('hidden')"
                                                class="text-gray-400 hover:text-gray-600 focus:outline-none">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="p-6">
                                        <form action="{{ route('updateCoupon', $coupon->id) }}" method="POST" class="space-y-5">
                                            @csrf
                                            @method('PUT')
                                            
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Coupon Code</label>
                                                <div class="relative">
                                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                        <i class="fas fa-ticket-alt text-gray-400"></i>
                                                    </div>
                                                    <input type="text" name="code" value="{{ $coupon->code }}"
                                                        class="w-full border border-gray-300 pl-10 px-4 py-2 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                                        required>
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-2 gap-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Discount Type</label>
                                                    <select name="discount_type"
                                                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                                                        <option value="percentage" {{ $coupon->discount_type == 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                                                        <option value="fixed" {{ $coupon->discount_type == 'fixed' ? 'selected' : '' }}>Fixed Amount (₹)</option>
                                                    </select>
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Discount Value</label>
                                                    <input type="number" name="discount_value" value="{{ $coupon->discount_value }}"
                                                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500"
                                                        required>
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-2 gap-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Min Order Amount</label>
                                                    <div class="relative">
                                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                            <span class="text-gray-500">₹</span>
                                                        </div>
                                                        <input type="number" name="min_order_amount"
                                                            value="{{ $coupon->min_order_amount }}"
                                                            class="w-full border border-gray-300 pl-8 px-4 py-2 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                                    </div>
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Max Discount Amount</label>
                                                    <div class="relative">
                                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                            <span class="text-gray-500">₹</span>
                                                        </div>
                                                        <input type="number" name="max_discount_amount"
                                                            value="{{ $coupon->max_discount_amount }}"
                                                            class="w-full border border-gray-300 pl-8 px-4 py-2 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-2 gap-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Valid From</label>
                                                    <div class="relative">
                                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                            <i class="fas fa-calendar-alt text-gray-400"></i>
                                                        </div>
                                                        <input type="date" name="valid_from"
                                                            value="{{ \Carbon\Carbon::parse($coupon->valid_from)->format('Y-m-d') }}"
                                                            class="w-full border border-gray-300 pl-10 px-4 py-2 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                                    </div>
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Valid Until</label>
                                                    <div class="relative">
                                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                            <i class="fas fa-calendar-alt text-gray-400"></i>
                                                        </div>
                                                        <input type="date" name="valid_until"
                                                            value="{{ \Carbon\Carbon::parse($coupon->valid_until)->format('Y-m-d') }}"
                                                            class="w-full border border-gray-300 pl-10 px-4 py-2 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-2 gap-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Usage Limit</label>
                                                    <input type="number" name="usage_limit" value="{{ $coupon->usage_limit }}"
                                                        placeholder="Leave empty for unlimited"
                                                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                                    <select name="status" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                                                        <option value="active" {{ $coupon->status == 'active' ? 'selected' : '' }}>Active</option>
                                                        <option value="inactive" {{ $coupon->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="pt-4 border-t border-gray-200 flex justify-end gap-3">
                                                <button type="button" 
                                                    onclick="document.getElementById('editModal-{{ $coupon->id }}').classList.add('hidden')"
                                                    class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300">
                                                    Cancel
                                                </button>
                                                <button type="submit"
                                                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                    Update Coupon
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>


                    @empty
                        <tr>
                            <td colspan="12" class="px-6 py-8 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-ticket-alt text-gray-300 text-5xl mb-4"></i>
                                    <p class="text-lg font-medium text-gray-600">No coupons available</p>
                                    <p class="text-gray-400 mt-1">Create your first coupon to offer discounts to customers</p>
                                    <button id="openEmptyCouponModal" class="mt-4 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md flex items-center gap-2">
                                        <i class="fas fa-plus"></i>
                                        <span>Add Coupon</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if(count($coupons) > 0)
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-600">Showing {{ count($coupons) }} coupons</p>
                <!-- Pagination could be added here if needed -->
            </div>
        </div>
        @endif
    </div>
</div>




    {{-- Add Coupon Modal --}}
    <div id="couponModal" class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm hidden justify-center items-center z-50 p-4">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg relative">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-gray-800">Add New Coupon</h2>
                    <button id="closeCouponModal" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <div class="p-6">
                <form action="{{ route('addCoupons') }}" method="POST" class="space-y-5">
                    @csrf
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Coupon Code</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-ticket-alt text-gray-400"></i>
                            </div>
                            <input type="text" name="code" placeholder="e.g. SUMMER2023"
                                class="w-full border border-gray-300 pl-10 px-4 py-2 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                required>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Use uppercase letters and numbers for better readability</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Discount Type</label>
                            <select name="discount_type" 
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                                <option value="percentage">Percentage (%)</option>
                                <option value="fixed">Fixed Amount (₹)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Discount Value</label>
                            <input type="number" name="discount_value" placeholder="e.g. 10"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500"
                                required>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Min Order Amount</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500">₹</span>
                                </div>
                                <input type="number" name="min_order_amount" placeholder="Optional"
                                    class="w-full border border-gray-300 pl-8 px-4 py-2 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Max Discount Amount</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500">₹</span>
                                </div>
                                <input type="number" name="max_discount_amount" placeholder="Optional"
                                    class="w-full border border-gray-300 pl-8 px-4 py-2 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Valid From</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-calendar-alt text-gray-400"></i>
                                </div>
                                <input type="date" name="valid_from" value="{{ date('Y-m-d') }}"
                                    class="w-full border border-gray-300 pl-10 px-4 py-2 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Valid Until</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-calendar-alt text-gray-400"></i>
                                </div>
                                <input type="date" name="valid_until" value="{{ date('Y-m-d', strtotime('+30 days')) }}"
                                    class="w-full border border-gray-300 pl-10 px-4 py-2 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Usage Limit</label>
                            <input type="number" name="usage_limit" placeholder="Leave empty for unlimited"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                            <p class="text-xs text-gray-500 mt-1">How many times this coupon can be used</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select name="status" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-200 flex justify-end gap-3">
                        <button type="button" id="cancelCouponBtn"
                            class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Create Coupon
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Add Coupon Modal Controls
        const couponModal = document.getElementById('couponModal');
        const openCouponModal = document.getElementById('openCouponModal');
        const closeCouponModal = document.getElementById('closeCouponModal');
        const cancelCouponBtn = document.getElementById('cancelCouponBtn');
        const openEmptyCouponModal = document.getElementById('openEmptyCouponModal');

        // Function to open modal
        function openCouponModalFunc() {
            couponModal.classList.remove('hidden');
            couponModal.classList.add('flex');
        }

        // Function to close modal
        function closeCouponModalFunc() {
            couponModal.classList.add('hidden');
            couponModal.classList.remove('flex');
        }

        // Add event listeners
        if (openCouponModal) {
            openCouponModal.addEventListener('click', openCouponModalFunc);
        }
        
        if (openEmptyCouponModal) {
            openEmptyCouponModal.addEventListener('click', openCouponModalFunc);
        }
        
        closeCouponModal.addEventListener('click', closeCouponModalFunc);
        cancelCouponBtn.addEventListener('click', closeCouponModalFunc);

        // Close when clicking outside modal
        window.addEventListener('click', (e) => {
            if (e.target === couponModal) {
                closeCouponModalFunc();
            }
        });
    </script>

@endsection