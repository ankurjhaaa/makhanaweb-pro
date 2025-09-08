@extends('admin.layout')

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

    {{-- Product Table Card --}}
    <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100">
        {{-- Filters --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
            {{-- Search --}}
            <div class="relative w-full md:w-1/3">
                <input type="search" id="product-search"
                       class="block w-full pl-10 pr-3 py-2 text-sm border border-gray-300 rounded-xl focus:ring-green-500 focus:border-green-500 placeholder-gray-400"
                       placeholder="Search products...">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                         viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                         d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
            </div>

            {{-- Sort --}}
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

        {{-- Table --}}
        <div class="overflow-x-auto rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100 sticky top-0">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Stock</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    {{-- Row Example --}}
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <img class="h-12 w-12 rounded-lg object-cover border" src="https://via.placeholder.com/150" alt="Product">
                                <div class="ml-4">
                                    <div class="text-sm font-semibold text-gray-900">Cool Gadget Pro</div>
                                    <div class="text-xs text-gray-500">SKU: #CGP-1234</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">Electronics</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 font-medium">$199.99</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">150</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                In Stock
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-3">
                            <a href="#" class="text-indigo-600 hover:text-indigo-900 font-medium">Edit</a>
                            <a href="#" class="text-red-600 hover:text-red-900 font-medium">Delete</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Add Product Modal --}}
<div id="addProductModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white w-full max-w-lg rounded-2xl shadow-lg p-6 relative">
        <h2 class="text-2xl font-bold mb-4">Add New Product</h2>
        
        <form class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Product Name</label>
                <input type="text" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500" placeholder="Enter product name">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Category</label>
                <select class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">
                    <option>Electronics</option>
                    <option>Snacks</option>
                    <option>Drinks</option>
                </select>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Price</label>
                    <input type="number" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500" placeholder="0.00">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Stock</label>
                    <input type="number" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500" placeholder="0">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Upload Image</label>
                <input type="file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
            </div>
            
            <div class="flex justify-end space-x-3 mt-6">
                <button type="button" onclick="document.getElementById('addProductModal').classList.add('hidden')" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection
