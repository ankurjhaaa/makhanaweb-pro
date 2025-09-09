@extends('admin.layout')

@section('title', 'All Combos')

@section('content')
    <div class="p-6 mt-20">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">All Combos</h1>
            <button onclick="document.getElementById('comboModal').classList.remove('hidden')"
                class="px-4 py-2 bg-blue-600 text-white rounded shadow hover:bg-blue-700 transition">
                + Add Combo
            </button>
        </div>
        

        <div id="comboModal" class="hidden">
            <div class=" fixed inset-0 bg-black/30 bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white rounded-xl w-96 p-6 relative shadow-lg">
                    <h2 class="text-xl font-bold mb-4">Create Product / Combo Pricing</h2>

                    <form method="POST" action="{{ route('addProductCombo') }}">
                        @csrf

                        <label class="block mb-3">
                            <span class="font-medium">Single Product (optional)</span>
                            <select id="singleProduct" name="product_id" class="w-full border rounded px-2 py-1 mt-1">
                                <option value="">-- Select Product --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }} (₹{{ $product->price }} | Stock =
                                        {{ $product->stock }})
                                    </option>
                                @endforeach
                            </select>
                        </label>

                        <label class="block mb-3">
                            <span class="font-medium">Combo Products (optional)</span>
                            <div id="comboProducts" class="mt-2 max-h-60 overflow-y-auto border rounded p-2 space-y-1">
                                @foreach($products as $product)
                                    <label class="flex items-center space-x-2">
                                        <input type="checkbox" name="combo_products[]" value="{{ $product->id }}"
                                            class="h-4 w-4">
                                        <span>{{ $product->name }} (₹{{ $product->price }} | Stock =
                                            {{ $product->stock }})</span>
                                    </label>
                                @endforeach
                            </div>
                        </label>

                        <script>
                            const singleSelect = document.getElementById('singleProduct');
                            const comboCheckboxes = document.querySelectorAll('#comboProducts input[type="checkbox"]');

                            // Agar single product select ho, combo disable ho
                            singleSelect.addEventListener('change', () => {
                                if (singleSelect.value) {
                                    comboCheckboxes.forEach(cb => cb.disabled = true);
                                } else {
                                    comboCheckboxes.forEach(cb => cb.disabled = false);
                                }
                            });

                            // Agar koi combo checkbox tick ho, single product disable ho
                            comboCheckboxes.forEach(cb => {
                                cb.addEventListener('change', () => {
                                    const anyChecked = Array.from(comboCheckboxes).some(c => c.checked);
                                    singleSelect.disabled = anyChecked;
                                });
                            });
                        </script>

                        <label class="block mb-3">
                            <span class="font-medium">Quantity</span>
                            <input type="number" name="quantity" value="1" min="1"
                                class="w-full border rounded px-2 py-1 mt-1" required>
                        </label>

                        <label class="block mb-4">
                            <span class="font-medium">Price</span>
                            <input type="number" name="price" class="w-full border rounded px-2 py-1 mt-1" required>
                        </label>

                        <div class="flex justify-end space-x-2">
                            <button type="button" onclick="document.getElementById('comboModal').classList.add('hidden')"
                                class="px-3 py-1 bg-gray-400 text-white rounded hover:bg-gray-500">Cancel</button>
                            <button type="submit"
                                class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">Save</button>
                        </div>
                    </form>

                    <button onclick="document.getElementById('comboModal').classList.add('hidden')"
                        class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-lg font-bold">&times;</button>
                </div>
            </div>
        </div>


        {{-- Combos Table --}}
        <div class="mt-6 bg-white shadow rounded-lg overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left font-medium text-gray-700">ID</th>
                        <th class="px-4 py-2 text-left font-medium text-gray-700">Single Product</th>
                        <th class="px-4 py-2 text-left font-medium text-gray-700">Combo Products</th>
                        <th class="px-4 py-2 text-left font-medium text-gray-700">Quantity</th>
                        <th class="px-4 py-2 text-left font-medium text-gray-700">Price</th>
                        <th class="px-4 py-2 text-left font-medium text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($combos as $combo)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $combo->id }}</td>
                            <td class="px-4 py-2">
                                @php $prod = $products->firstWhere('id', $combo->product_id); @endphp
                                {{ $prod?->name ?? '-' }}
                            </td>
                            @php
                                $comboProducts = $combo->combo_products ? json_decode($combo->combo_products, true) : [];
                            @endphp

                            <td class="px-4 py-2">
                                @if(!empty($comboProducts))
                                    @foreach($comboProducts as $prodId)
                                        @php $prod = $products->firstWhere('id', $prodId); @endphp
                                        <span class="inline-block bg-blue-100 text-blue-700 px-2 py-0.5 rounded mr-1 mb-1 text-xs">
                                            {{ $prod?->name ?? 'N/A' }}
                                        </span>
                                    @endforeach
                                @else
                                    -
                                @endif
                            </td>

                            <td class="px-4 py-2">{{ $combo->quantity }}</td>
                            <td class="px-4 py-2">₹{{ $combo->price }}</td>
                            <td class="px-4 py-2 space-x-2 flex">
                                <button
                                    class="px-2 py-1 bg-yellow-400 text-white rounded hover:bg-yellow-500 text-xs">Edit</button>
                                <form action="{{ route('deleteCombos', $combo->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-xs">Delete</button>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection