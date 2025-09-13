@extends('admin.layout')

@section('title', 'Products Management')

@section('content')
    <div class="pt-8 pb-4">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Products</h1>
                <p class="text-gray-600 mt-1">Manage your product catalog</p>
            </div>

            <div class="mt-4 md:mt-0">
                <button onclick="document.getElementById('addProductModal').classList.remove('hidden')"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md shadow flex items-center gap-2">
                    <i class="fas fa-plus"></i>
                    <span>Add Product</span>
                </button>
            </div>
        </div>

        <div class="bg-white shadow-sm border border-gray-200 rounded-xl overflow-hidden">
            <div class="p-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <form method="GET" action="{{ route('searchProducts') }}" class="flex w-full md:w-96">
                        <div class="relative flex-grow">
                            <input type="search" name="search" value="{{ request('search') }}"
                                class="w-full pl-10 pr-4 py-2 text-sm border border-gray-300 rounded-l-md focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Search products...">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                        </div>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-r-md hover:bg-blue-700 text-sm font-medium">
                            Search
                        </button>
                    </form>

                    <div class="flex items-center gap-3">
                        <label for="sort-by" class="text-sm text-gray-600">Sort by:</label>
                        <select id="sort-by"
                            class="text-sm border border-gray-300 rounded-md px-3 py-2 bg-white focus:ring-blue-500 focus:border-blue-500">
                            <option value="name">Name</option>
                            <option value="price">Price</option>
                            <option value="stock">Stock</option>
                        </select>
                    </div>
                </div>
            </div>


            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Product
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Category</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Price
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Stock
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($products as $product)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <img class="h-12 w-12 rounded-lg object-cover border"
                                            src="{{ $product->imagelink }}?tr=w-200,h-200,fo-face,q-10" alt="Product">
                                        <div class="ml-4">
                                            <div class="text-sm font-semibold text-gray-900">{{ $product->name }}</div>
                                            <div class="text-xs text-gray-500">SKU: #{{ $product->id }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $product->category->name ?? '—' }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 font-medium">
                                    ₹{{ number_format($product->price, 2) }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $product->stock }}</td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($product->stock > 10)
                                        <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">
                                            In Stock
                                        </span>
                                    @elseif($product->stock > 0)
                                        <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">
                                            Low Stock
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded-full">
                                            Out of Stock
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="flex items-center justify-end space-x-3">
                                        <button onclick="openComboModal({{ $product->id }}, '{{ $product->name }}')"
                                            class="text-blue-600 hover:text-blue-900" title="Make Combo">
                                            <i class="fas fa-object-group"></i>
                                        </button>
                                        <button
                                            onclick="document.getElementById('editProductModal-{{ $product->id }}').classList.remove('hidden')"
                                            class="text-blue-600 hover:text-blue-900" title="Edit Product">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('deleteProduct', $product->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Are you sure you want to delete this product?')"
                                                class="text-red-600 hover:text-red-900" title="Delete Product">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            {{-- Moved outside the loop since it's a single modal --}}



                            <!-- Edit Modal -->
                            <div id="editProductModal-{{ $product->id }}" class="hidden">
                                <div
                                    class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm flex justify-center items-center z-50 p-4">
                                    <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg relative">
                                        <div class="px-6 py-4 border-b border-gray-200">
                                            <div class="flex items-center justify-between">
                                                <h2 class="text-xl font-bold text-gray-800">Edit Product</h2>
                                                <button
                                                    onclick="document.getElementById('editProductModal-{{ $product->id }}').classList.add('hidden')"
                                                    class="text-gray-400 hover:text-gray-600 focus:outline-none">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="p-6">
                                            <form method="POST" action="{{ route('updateProduct', $product->id) }}"
                                                enctype="multipart/form-data" class="space-y-5">
                                                @csrf
                                                @method('PUT')

                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Product
                                                        Name</label>
                                                    <input type="text" name="name" value="{{ $product->name }}"
                                                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500"
                                                        required>
                                                </div>

                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                                                    <div class="relative">
                                                        <select name="category_id"
                                                            class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white focus:ring-blue-500 focus:border-blue-500 appearance-none"
                                                            required>
                                                            @foreach($categories as $cat)
                                                                <option value="{{ $cat->id }}" @if($cat->id == $product->category_id)
                                                                selected @endif>
                                                                    {{ $cat->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <div
                                                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                                            <i class="fas fa-chevron-down text-xs"></i>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="grid grid-cols-2 gap-4">
                                                    <div>
                                                        <label
                                                            class="block text-sm font-medium text-gray-700 mb-1">Price</label>
                                                        <div class="relative">
                                                            <div
                                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                                <span class="text-gray-500">₹</span>
                                                            </div>
                                                            <input type="number" step="0.01" name="price"
                                                                value="{{ $product->price }}"
                                                                class="w-full border border-gray-300 pl-8 px-4 py-2 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <label
                                                            class="block text-sm font-medium text-gray-700 mb-1">Stock</label>
                                                        <input type="number" name="stock" value="{{ $product->stock }}"
                                                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500"
                                                            required>
                                                    </div>
                                                </div>

                                                <div>
                                                    <label
                                                        class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                                    <textarea name="description" rows="3"
                                                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500">{{ $product->description }}</textarea>
                                                </div>

                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Product
                                                        Image</label>
                                                    <div class="flex items-center space-x-4">
                                                        <div class="h-16 w-16 rounded-lg overflow-hidden bg-gray-100 border">
                                                            <img src="{{ $product->image_url }}?tr=w-100,h-100"
                                                                alt="{{ $product->name }}" class="h-full w-full object-cover">
                                                        </div>
                                                        <div class="flex-1">
                                                            <label
                                                                class="cursor-pointer block w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-100 text-center">
                                                                <span>Change image</span>
                                                                <input type="file" name="image" class="hidden">
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="pt-4 border-t border-gray-200 flex justify-end gap-3">
                                                    <button type="button"
                                                        onclick="document.getElementById('editProductModal-{{ $product->id }}').classList.add('hidden')"
                                                        class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300">
                                                        Cancel
                                                    </button>
                                                    <button type="submit"
                                                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                        Update Product
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-box-open text-gray-300 text-5xl mb-4"></i>
                                        <p class="text-lg font-medium text-gray-600">No products available</p>
                                        <p class="text-gray-400 mt-1">Add your first product to start selling</p>
                                        <button onclick="document.getElementById('addProductModal').classList.remove('hidden')"
                                            class="mt-4 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md flex items-center gap-2">
                                            <i class="fas fa-plus"></i>
                                            <span>Add Product</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(count($products) > 0)
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <p class="text-sm text-gray-600">Showing {{ count($products) }} products</p>
                        <!-- Pagination could be added here if needed -->
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Add Product Modal --}}
    <div id="addProductModal" class="hidden">
        <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm flex justify-center items-center z-50 p-4">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg relative">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-bold text-gray-800">Add New Product</h2>
                        <button onclick="document.getElementById('addProductModal').classList.add('hidden')"
                            class="text-gray-400 hover:text-gray-600 focus:outline-none">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <div class="p-6 max-h-[80vh] overflow-y-auto">
                    <form method="POST" action="{{ route('addProducts') }}" enctype="multipart/form-data" class="space-y-5">
                        @csrf

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Product Name</label>
                            <input type="text" name="name" placeholder="Enter product name"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500"
                                required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                            <div class="relative">
                                <select name="category_id"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white focus:ring-blue-500 focus:border-blue-500 appearance-none"
                                    required>
                                    <option value="">-- Select Category --</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                                <div
                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Price</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500">₹</span>
                                    </div>
                                    <input type="number" step="0.01" name="price" placeholder="0.00"
                                        class="w-full border border-gray-300 pl-8 px-4 py-2 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                        required>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Stock</label>
                                <input type="number" name="stock" placeholder="0"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500"
                                    required>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">mrp</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500">₹</span>
                                    </div>
                                    <input type="number" step="0.01" name="mrp" placeholder="0.00" value="1"
                                        class="w-full border border-gray-300 pl-8 px-4 py-2 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                        required>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <!-- Quantity Input -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                                    <input type="number" name="quantity" placeholder="1" min="1"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500"
                                        required>
                                </div>

                                <!-- Unit Select -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Unit</label>
                                    <select name="unit"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500"
                                        required>
                                        <option value="kg">Kg</option>
                                        <option value="g">Gram</option>
                                        <option value="l">Litre</option>
                                        <option value="ml">Millilitre</option>
                                        <option value="pcs">Pieces</option>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Product Image</label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-4">
                                <div class="text-center">
                                    <i class="fas fa-cloud-upload-alt text-gray-400 text-3xl mb-2"></i>
                                    <p class="text-sm text-gray-500 mb-1">Drag and drop an image or</p>
                                    <label class="cursor-pointer inline-block">
                                        <span class="text-sm text-blue-600 hover:text-blue-700">Browse files</span>
                                        <input type="file" name="image" class="hidden">
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea name="description" rows="3" placeholder="Enter product description"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                        </div>

                        <div class="pt-4 border-t border-gray-200 flex justify-end gap-3">
                            <button type="button"
                                onclick="document.getElementById('addProductModal').classList.add('hidden')"
                                class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300">
                                Cancel
                            </button>
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                Create Product
                            </button>
                        </div>
                    </form>
                </div>


            </div>
        </div>
    </div>

    {{-- Combo Modal (single instance, outside loop) --}}
    <div id="comboModal" class="hidden">
        <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm flex justify-center items-center z-50 p-4">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg relative">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-bold text-gray-800">Create Product Combo</h2>
                        <button onclick="closeComboModal()" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <div class="p-6">
                    <form action="{{ route('addProductCombo') }}" method="POST" class="space-y-5">
                        @csrf
                        <input type="hidden" name="base_product_id" id="comboBaseProductId">

                        <div class="bg-blue-50 rounded-lg p-4 mb-4">
                            <div class="flex items-center">
                                <div class="rounded-full bg-blue-100 p-2 mr-3">
                                    <i class="fas fa-box text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Base Product:</p>
                                    <p class="font-medium text-gray-900" id="comboBaseProductName"></p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-hashtag text-gray-400"></i>
                                </div>
                                <input type="number" name="quantity" min="2" value="2" required
                                    class="w-full border border-gray-300 pl-10 px-4 py-2 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <p class="text-xs text-gray-500 mt-1">How many items in this combo pack</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Combo Price</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500">₹</span>
                                </div>
                                <input type="number" name="price" step="0.01" required
                                    class="w-full border border-gray-300 pl-8 px-4 py-2 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Set a discounted price for the combo</p>
                        </div>

                        <div class="pt-4 border-t border-gray-200 flex justify-end gap-3">
                            <button type="button" onclick="closeComboModal()"
                                class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300">
                                Cancel
                            </button>
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                Create Combo
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Combo Modal Script --}}
    <script>
        function openComboModal(productId, productName) {
            document.getElementById('comboModal').classList.remove('hidden');
            document.getElementById('comboBaseProductId').value = productId;
            document.getElementById('comboBaseProductName').innerText = productName;
        }

        function closeComboModal() {
            document.getElementById('comboModal').classList.add('hidden');
        }
    </script>
@endsection