@extends('admin.layout')

@section('title', 'Coupons Page')

@section('content')
    <div class="bg-white shadow rounded-lg mt-20 p-4">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold text-gray-800">Coupons</h2>
            <button id="openCouponModal" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                + Add Coupon
            </button>
        </div>

        <div class="w-full overflow-x-auto">
            <table class="min-w-max border border-gray-200 rounded-lg text-sm">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-2 border whitespace-nowrap">#</th>
                        <th class="px-4 py-2 border whitespace-nowrap">Code</th>
                        <th class="px-4 py-2 border whitespace-nowrap">Discount Type</th>
                        <th class="px-4 py-2 border whitespace-nowrap">Discount Value</th>
                        <th class="px-4 py-2 border whitespace-nowrap">Min Order Amount</th>
                        <th class="px-4 py-2 border whitespace-nowrap">Max Discount Amount</th>
                        <th class="px-4 py-2 border whitespace-nowrap">Valid From</th>
                        <th class="px-4 py-2 border whitespace-nowrap">Valid Until</th>
                        <th class="px-4 py-2 border whitespace-nowrap">Usage Limit</th>
                        <th class="px-4 py-2 border whitespace-nowrap">Used Count</th>
                        <th class="px-4 py-2 border whitespace-nowrap">Status</th>
                        <th class="px-4 py-2 border whitespace-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($coupons as $coupon)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border text-center">{{ $coupon->id }}</td>
                            <td class="px-4 py-2 border">{{ $coupon->code }}</td>
                            <td class="px-4 py-2 border">{{ $coupon->discount_type }}</td>
                            <td class="px-4 py-2 border">{{ $coupon->discount_value }}</td>
                            <td class="px-4 py-2 border">{{ $coupon->min_order_amount }}</td>
                            <td class="px-4 py-2 border">{{ $coupon->max_discount_amount }}</td>
                            <td class="px-4 py-2 border">{{ \Carbon\Carbon::parse($coupon->valid_from)->format('d M Y') }}</td>
                            <td class="px-4 py-2 border">{{ \Carbon\Carbon::parse($coupon->valid_until)->format('d M Y') }}</td>
                            <td class="px-4 py-2 border">{{ $coupon->usage_limit }}</td>
                            <td class="px-4 py-2 border">{{ $coupon->used_count }}</td>
                            <td class="px-4 py-2 border">
                                <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded">{{ $coupon->status }}</span>
                            </td>
                            <td class="px-4 py-2 border text-center whitespace-nowrap flex space-x-1">
                                <button
                                    onclick="document.getElementById('editModal-{{ $coupon->id }}').classList.remove('hidden')"
                                    class="px-2 py-1 bg-yellow-400 text-white rounded hover:bg-yellow-500">
                                    Edit
                                </button>
                                <form action="{{ route('deleteCoupon', $coupon->id) }}" method="post"
                                    class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">Delete</button>
                                </form>

                            </td>
                        </tr>
                        {{-- Edit Modal --}}
                        <div id="editModal-{{ $coupon->id }}" class="hidden">
                            <div class="fixed inset-0 bg-black/30  flex justify-center items-center z-50 p-3">
                                <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative">

                                    {{-- Close Button --}}
                                    <button
                                        onclick="document.getElementById('editModal-{{ $coupon->id }}').classList.add('hidden')"
                                        class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-2xl">
                                        &times;
                                    </button>

                                    <h2 class="text-xl font-semibold mb-4 text-yellow-600">Edit Coupon</h2>

                                    <form action="{{ route('updateCoupon', $coupon->id) }}" method="POST" class="space-y-4">
                                        @csrf
                                        @method('PUT')

                                        <div>
                                            <label class="block text-sm font-medium mb-1">Coupon Code</label>
                                            <input type="text" name="code" value="{{ $coupon->code }}"
                                                class="w-full border rounded px-3 py-2 focus:ring focus:ring-yellow-300"
                                                required>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium mb-1">Discount Type</label>
                                            <select name="discount_type"
                                                class="w-full border rounded px-3 py-2 focus:ring focus:ring-yellow-300">
                                                <option value="percentage" {{ $coupon->discount_type == 'percentage' ? 'selected' : '' }}>Percentage</option>
                                                <option value="fixed" {{ $coupon->discount_type == 'fixed' ? 'selected' : '' }}>
                                                    Fixed
                                                </option>
                                            </select>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium mb-1">Discount Value</label>
                                            <input type="number" name="discount_value" value="{{ $coupon->discount_value }}"
                                                class="w-full border rounded px-3 py-2 focus:ring focus:ring-yellow-300"
                                                required>
                                        </div>

                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium mb-1">Min Order Amount</label>
                                                <input type="number" name="min_order_amount"
                                                    value="{{ $coupon->min_order_amount }}"
                                                    class="w-full border rounded px-3 py-2">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-1">Max Discount Amount</label>
                                                <input type="number" name="max_discount_amount"
                                                    value="{{ $coupon->max_discount_amount }}"
                                                    class="w-full border rounded px-3 py-2">
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium mb-1">Valid From</label>
                                                <input type="date" name="valid_from"
                                                    value="{{ \Carbon\Carbon::parse($coupon->valid_from)->format('Y-m-d') }}"
                                                    class="w-full border rounded px-3 py-2">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-1">Valid Until</label>
                                                <input type="date" name="valid_until"
                                                    value="{{ \Carbon\Carbon::parse($coupon->valid_until)->format('Y-m-d') }}"
                                                    class="w-full border rounded px-3 py-2">
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium mb-1">Usage Limit</label>
                                                <input type="number" name="usage_limit" value="{{ $coupon->usage_limit }}"
                                                    class="w-full border rounded px-3 py-2">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-1">Status</label>
                                                <select name="status" class="w-full border rounded px-3 py-2">
                                                    <option value="active" {{ $coupon->status == 'active' ? 'selected' : '' }}>
                                                        Active
                                                    </option>
                                                    <option value="inactive" {{ $coupon->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="flex justify-end">
                                            <button type="submit"
                                                class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700">
                                                Update Coupon
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>


                    @empty
                        <tr>
                            <td colspan="12" class="border px-3 py-4 text-center text-gray-500 font-medium">
                                No coupon available right now
                            </td>
                        </tr>
                    @endforelse



                </tbody>
            </table>
        </div>
    </div>




    {{-- Modal --}}
    <div id="couponModal" class="fixed inset-0 bg-black/20 bg-opacity-50 hidden justify-center items-center z-50 p-3">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative">

            <button id="closeCouponModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-2xl">
                &times;
            </button>

            <h2 class="text-xl font-semibold mb-4 text-blue-600">Add New Coupon</h2>
            <form action="{{ route('addCoupons') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium mb-1">Coupon Code</label>
                    <input type="text" name="code" class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300"
                        required>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Discount Type</label>
                    <select name="discount_type" class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300">
                        <option value="percentage">Percentage</option>
                        <option value="fixed">Fixed</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Discount Value</label>
                    <input type="number" name="discount_value"
                        class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300" required>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Min Order Amount</label>
                        <input type="number" name="min_order_amount" class="w-full border rounded px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Max Discount Amount</label>
                        <input type="number" name="max_discount_amount" class="w-full border rounded px-3 py-2">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Valid From</label>
                        <input type="date" name="valid_from" class="w-full border rounded px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Valid Until</label>
                        <input type="date" name="valid_until" class="w-full border rounded px-3 py-2">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Usage Limit</label>
                        <input type="number" name="usage_limit" class="w-full border rounded px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Status</label>
                        <select name="status" class="w-full border rounded px-3 py-2">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Save Coupon
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const couponModal = document.getElementById('couponModal');
        const openCouponModal = document.getElementById('openCouponModal');
        const closeCouponModal = document.getElementById('closeCouponModal');

        openCouponModal.addEventListener('click', () => {
            couponModal.classList.remove('hidden');
            couponModal.classList.add('flex');
        });

        closeCouponModal.addEventListener('click', () => {
            couponModal.classList.add('hidden');
            couponModal.classList.remove('flex');
        });

        // Close when clicking outside modal
        window.addEventListener('click', (e) => {
            if (e.target === couponModal) {
                couponModal.classList.add('hidden');
                couponModal.classList.remove('flex');
            }
        });
    </script>

@endsection