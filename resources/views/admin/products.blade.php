@extends('admin.layout')

@section('title', 'Products Management')

@section('content')
    <div class="space-y-8">
        {{-- Header --}}
        <div class="flex items-center justify-between">
            <h1 class="text-3xl font-extrabold text-gray-800">Products Management 📦</h1>
            <button onclick="document.getElementById('addProductModal').classList.remove('hidden')"
                class="px-5 py-2.5 text-sm font-semibold text-white bg-green-600 rounded-xl shadow hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-1 transition">
                + Add New Product
            </button>
        </div>
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-2 rounded mb-3">
                {{ session('success') }}
            </div>
        @endif
        <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
                <div class="relative w-full md:w-1/2">
                    <form method="GET" action="{{ route('searchProducts') }}"
                        class="flex items-center gap-2 w-full md:w-1/2 mb-4">
                        <div class="relative flex-1">
                            <input type="search" name="search" value="{{ request('search') }}"
                                class="w-full pl-12 pr-4 py-2 text-sm border border-gray-300 rounded-xl focus:ring-green-500 focus:border-green-500 placeholder-gray-400 shadow-sm"
                                placeholder="Search products...">
                        </div>

                        <button type="submit"
                            class="px-4 py-2 bg-green-600 text-white rounded-xl shadow hover:bg-green-700 transition font-semibold text-sm">
                            Search
                        </button>
                    </form>


                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>

                <div class="flex items-center space-x-2">
                    <span class="text-gray-500 text-sm">Sort by:</span>
                    <select id="sort-by"
                        class="p-2 text-sm border border-gray-300 rounded-xl bg-gray-50 focus:ring-green-500 focus:border-green-500">
                        <option value="name">Name</option>
                        <option value="price">Price</option>
                        <option value="stock">Stock</option>
                    </select>
                </div>
            </div>

            <div class="overflow-x-auto rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100 sticky top-0">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Product
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                Category</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Price
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Stock
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Status
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-gray-600 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($products as $product)
                            <tr class="hover:bg-gray-50 transition">
                                {{-- Product --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <img class="h-12 w-12 rounded-lg object-cover border"
                                            src="{{ asset('storage/' . $product->image) }}" alt="Product">
                                        <div class="ml-4">
                                            <div class="text-sm font-semibold text-gray-900">{{ $product->name }}</div>
                                            <div class="text-xs text-gray-500">SKU: #{{ $product->id }}</div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Category --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $product->category->name ?? '—' }}
                                </td>

                                {{-- Price --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 font-medium">
                                    ₹{{ number_format($product->price, 2) }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $product->stock }}</td>

                                <td>
                                    <span
                                        class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        In Stock
                                    </span>

                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-3">
                                    <button class="text-indigo-600 hover:text-indigo-900 font-medium"
                                        onclick="document.getElementById('editProductModal-{{ $product->id }}').classList.remove('hidden')">
                                        Edit
                                    </button>
                                    <form action="{{ route('deleteProduct', $product->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Delete this product?')"
                                            class="text-red-600 hover:text-red-900 font-medium">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            <!-- Edit Modal -->
                            <div id="editProductModal-{{ $product->id }}" class="hidden">
                                <div class=" fixed inset-0 z-50 flex items-center justify-center bg-black/40">
                                    <div class="bg-white w-full max-w-lg rounded-2xl shadow-lg p-6 relative">
                                        <button type="button"
                                            onclick="document.getElementById('editProductModal-{{ $product->id }}').classList.add('hidden')"
                                            class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">✕</button>

                                        <h2 class="text-2xl font-bold mb-4">Edit Product</h2>

                                        <form method="POST" action="{{ route('updateProduct', $product->id) }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')

                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Product Name</label>
                                                <input type="text" name="name" value="{{ $product->name }}"
                                                    class="mt-1 block w-full border rounded-lg px-3 py-2 shadow-sm focus:ring-green-500 focus:border-green-500"
                                                    required>
                                            </div>

                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Category</label>
                                                <select name="category_id"
                                                    class="mt-1 block w-full border rounded-lg px-3 py-2 shadow-sm focus:ring-green-500 focus:border-green-500"
                                                    required>
                                                    @foreach($categories as $cat)
                                                        <option value="{{ $cat->id }}" @if($cat->id == $product->category_id) selected
                                                        @endif>
                                                            {{ $cat->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="grid grid-cols-2 gap-4 mt-2">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Price</label>
                                                    <input type="number" step="0.01" name="price" value="{{ $product->price }}"
                                                        class="mt-1 block w-full border rounded-lg px-3 py-2 shadow-sm focus:ring-green-500 focus:border-green-500"
                                                        required>
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Stock</label>
                                                    <input type="number" name="stock" value="{{ $product->stock }}"
                                                        class="mt-1 block w-full border rounded-lg px-3 py-2 shadow-sm focus:ring-green-500 focus:border-green-500"
                                                        required>
                                                </div>
                                            </div>

                                            <div class="mt-2">
                                                <label class="block text-sm font-medium text-gray-700">Description</label>
                                                <textarea name="description"
                                                    class="mt-1 block w-full border rounded-lg px-3 py-2 shadow-sm focus:ring-green-500 focus:border-green-500">{{ $product->description }}</textarea>
                                            </div>

                                            <div class="mt-2">
                                                <label class="block text-sm font-medium text-gray-700">Upload Image</label>
                                                <input type="file" name="image"
                                                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold  file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                                                @if($product->image)
                                                    <img src="{{ asset('storage/' . $product->image) }}"
                                                        class="h-20 mt-2 rounded-lg" alt="product">
                                                @endif
                                            </div>

                                            <div class="flex justify-end space-x-3 mt-4">
                                                <button type="button"
                                                    onclick="document.getElementById('editProductModal-{{ $product->id }}').classList.add('hidden')"
                                                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Cancel</button>
                                                <button type="submit"
                                                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                    No products found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Add Product Modal --}}
    <div id="addProductModal" class="hidden">
        <div class=" fixed inset-0 z-50 flex items-center justify-center bg-black/40">
            <div class="bg-white w-full max-w-lg rounded-2xl shadow-lg p-6 relative">
                {{-- Close button --}}
                <button type="button" onclick="document.getElementById('addProductModal').classList.add('hidden')"
                    class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
                    ✕
                </button>

                <h2 class="text-2xl font-bold mb-4">Add New Product</h2>

                <form class="space-y-4" method="POST" action="{{ route('addProducts') }}" enctype="multipart/form-data">
                    @csrf

                    {{-- Product Name --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Product Name</label>
                        <input type="text" name="name"
                            class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 shadow-sm focus:ring-green-500 focus:border-green-500"
                            placeholder="Enter product name" required>
                    </div>

                    {{-- Category --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Category</label>
                        <select name="category_id"
                            class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 shadow-sm focus:ring-green-500 focus:border-green-500"
                            required>
                            <option value="">-- Select Category --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Price & Stock --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Price</label>
                            <input type="number" step="0.01" name="price"
                                class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 shadow-sm focus:ring-green-500 focus:border-green-500"
                                placeholder="0.00" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Stock</label>
                            <input type="number" name="stock"
                                class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 shadow-sm focus:ring-green-500 focus:border-green-500"
                                placeholder="0" required>
                        </div>
                    </div>
                    <input type="file" name="image"
                        class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold  file:bg-green-50 file:text-green-700 hover:file:bg-green-100">


                    <div>
                        <label class="block text-sm font-medium text-gray-700">description</label>
                        <textarea type="text" name="description"
                            class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 shadow-sm focus:ring-green-500 focus:border-green-500"> </textarea>
                    </div>

                    {{-- Buttons --}}
                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" onclick="document.getElementById('addProductModal').classList.add('hidden')"
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection