@extends('admin.layout')

@section('title', 'Category Page')

@section('content')

    <div class="pt-8 pb-4">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Categories</h1>
                <p class="text-gray-600 mt-1">Manage your product categories</p>
            </div>

            <div class="mt-4 md:mt-0">
                <button onclick="document.getElementById('categoryModal').classList.remove('hidden')"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md shadow flex items-center gap-2">
                    <i class="fas fa-plus"></i>
                    <span>Add Category</span>
                </button>
            </div>
        </div>


        <div class="bg-white shadow-sm border border-gray-200 rounded-xl overflow-hidden">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold text-gray-800">All Categories</h2>

                    <div class="relative">
                        <input type="text" placeholder="Search categories..."
                            class="py-2 pl-10 pr-4 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full text-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full divide-y divide-gray-200 text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-left">
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Description
                            </th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Parent</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">IS Show</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($categories as $cat)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap font-medium">{{ $cat->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $cat->name }}</td>
                                    <td class="px-6 py-4">
                                        <div class="max-w-xs truncate">{{ $cat->description ?: 'No description' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($cat->parent)
                                            <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">
                                                {{ $cat->parent->name }}
                                            </span>
                                        @else
                                            <span class="text-gray-400">—</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <form action="{{ route('toggleAdminCategoryShow', $cat->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')

                                            <button type="submit" class="px-3 py-1 rounded-full text-xs font-medium 
                               {{ $cat->is_show ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-600' }}">
                                                {{ $cat->is_show ? 'Visible' : 'Hidden' }}
                                            </button>
                                        </form>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex space-x-2">
                                            <button
                                                onclick="document.getElementById('editModal-{{ $cat->id }}').classList.remove('hidden')"
                                                class="text-blue-600 hover:text-blue-900" title="Edit Category">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form action="{{ route('deleteAdminCategory', $cat->id) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Are you sure you want to delete this category?')"
                                                    class="text-red-600 hover:text-red-900" title="Delete Category">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Edit Modal -->
                                <div id="editModal-{{ $cat->id }}" class="hidden">
                                    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
                                        <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6 relative">
                                            <button
                                                onclick="document.getElementById('editModal-{{ $cat->id }}').classList.add('hidden')"
                                                class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 focus:outline-none">
                                                <i class="fas fa-times"></i>
                                            </button>

                                            <div class="mb-5">
                                                <h2 class="text-xl font-bold text-gray-800">Edit Category</h2>
                                                <p class="text-gray-500 text-sm mt-1">Update category information</p>
                                            </div>

                                            <form action="{{ route('editAdminCategory', $cat->id) }}" method="POST" enctype="multipart/form-dataservre"
                                                class="space-y-4">
                                                @csrf
                                                @method('PUT')

                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Category
                                                        Name</label>
                                                    <input type="text" name="name" value="{{ $cat->name }}"
                                                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                                        required>
                                                </div>

                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                                    <textarea name="description" rows="3"
                                                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500">{{ $cat->description }}</textarea>
                                                </div>

                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Parent
                                                        Category</label>
                                                    <select name="parent_id"
                                                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                                                        <option value="">-- None --</option>
                                                        @foreach($categories as $parent)
                                                            @if($parent->id != $cat->id) {{-- Prevent selecting self as parent --}}
                                                                <option value="{{ $parent->id }}" {{ $cat->parent_id == $parent->id ? 'selected' : '' }}>
                                                                    {{ $parent->name }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-1">Category Image</label>
                                                        <input type="file" name="image" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                                                        
                                                             @if($cat->imagelink)
                                                                    <div class="mt-2">
                                                                        <img src="{{ $cat->imagelink }}" alt="Current Image"
                                                                             class="h-16 w-16 object-cover rounded">
                                                                    </div>
                                                             @endif
                                                    </div>
                                                        
                                                <div class="pt-4 flex justify-end gap-3">
                                                    <button type="button"
                                                        onclick="document.getElementById('editModal-{{ $cat->id }}').classList.add('hidden')"
                                                        class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300">
                                                        Cancel
                                                    </button>
                                                    <button type="submit"
                                                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                        Update Category
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-folder-open text-gray-300 text-5xl mb-4"></i>
                                        <p class="text-lg font-medium text-gray-600">No categories found</p>
                                        <p class="text-gray-400 mt-1">Add your first category to get started</p>
                                        <button onclick="document.getElementById('categoryModal').classList.remove('hidden')"
                                            class="mt-4 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md flex items-center gap-2">
                                            <i class="fas fa-plus"></i>
                                            <span>Add Category</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-gray-600">Showing {{ count($categories) }} categories</p>
                    <!-- Pagination could be added here if needed -->
                </div>
            </div>
        </div>
    </div>

    <!-- Category Modal -->
    <div id="categoryModal" class="hidden">
        <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
            <div class="bg-white w-full max-w-lg rounded-xl shadow-lg p-6 relative">
                <button onclick="document.getElementById('categoryModal').classList.add('hidden')"
                    class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 focus:outline-none">
                    <i class="fas fa-times"></i>
                </button>

                <div class="mb-5">
                    <h2 class="text-xl font-bold text-gray-800">Add New Category</h2>
                    <p class="text-gray-500 text-sm mt-1">Create a new product category</p>
                </div>

                <form action="{{ route('addAdminCategory') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-4">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Category Name</label>
                        <input type="text" name="name"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="e.g. Electronics, Clothing, etc." required>
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="description" rows="3"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Brief description of this category (optional)"></textarea>
                    </div>

                    <!-- Parent -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Parent Category</label>
                        <select name="parent_id"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">-- None (Top-level Category) --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Leave empty for top-level category</p>
                    </div>

                    <!-- Image Upload -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Category Image</label>
                        <input type="file" name="image" accept="image/*"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Upload an image for this category (optional)</p>
                    </div>

                    <!-- Buttons -->
                    <div class="pt-4 flex justify-end space-x-3">
                        <button type="button" onclick="document.getElementById('categoryModal').classList.add('hidden')"
                            class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-plus mr-1"></i> Add Category
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>




@endsection