@extends('admin.layout')

@section('title', 'Category Page')

@section('content')

    <div class="container mx-auto p-1 mt-20">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Categories</h1>
            <button onclick="document.getElementById('categoryModal').classList.remove('hidden')"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
                + Add Category
            </button>
        </div>

       
        <div class="bg-white shadow rounded p-4">
            <h2 class="text-xl font-semibold mb-3">All Categories</h2>

            <div class="overflow-x-auto">
                <table class="w-full border-collapse border border-gray-200 text-sm">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="border px-3 py-2">#</th>
                            <th class="border px-3 py-2">Name</th>
                            <th class="border px-3 py-2">Description</th>
                            <th class="border px-3 py-2">Parent</th>
                            <th class="border px-3 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $cat)
                            <tr>
                                <td class="border px-3 py-2">{{ $cat->id }}</td>
                                <td class="border px-3 py-2">{{ $cat->name }}</td>
                                <td class="border px-3 py-2">{{ $cat->description }}</td>
                                <td class="border px-3 py-2">{{ $cat->parent?->name ?? '—' }}</td>
                                <td class="border px-3 py-2 whitespace-nowrap">
                                    <button
                                        onclick="document.getElementById('editModal-{{ $cat->id }}').classList.remove('hidden')"
                                        class="text-blue-600 hover:underline mr-2">
                                        Edit
                                    </button>
                                    <form action="{{ route('deleteAdminCategory', $cat->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Delete this category?')"
                                            class="text-red-600 hover:underline">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Edit Modal -->
                            <div id="editModal-{{ $cat->id }}" class="hidden">
                                <div class=" fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
                                    <div class="bg-white rounded-md shadow-lg w-full max-w-md p-6">
                                        <div class="flex justify-between items-center mb-4">
                                            <h2 class="text-xl font-semibold">Edit Category</h2>
                                            <button
                                                onclick="document.getElementById('editModal-{{ $cat->id }}').classList.add('hidden')"
                                                class="text-gray-600 hover:text-gray-900 text-2xl leading-none">&times;</button>
                                        </div>

                                        <form action="{{ route('editAdminCategory', $cat->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <div class="mb-3">
                                                <label class="block text-gray-700">Category Name</label>
                                                <input type="text" name="name" value="{{ $cat->name }}"
                                                    class="w-full border rounded px-3 py-2" required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="block text-gray-700">Description</label>
                                                <textarea name="description"
                                                    class="w-full border rounded px-3 py-2">{{ $cat->description }}</textarea>
                                            </div>

                                            <div class="mb-3">
                                                <label class="block text-gray-700">Parent Category</label>
                                                <select name="parent_id" class="w-full border rounded px-3 py-2">
                                                    <option value="">-- None --</option>
                                                    @foreach($categories as $parent)
                                                        <option value="{{ $parent->id }}" {{ $cat->parent_id == $parent->id ? 'selected' : '' }}>
                                                            {{ $parent->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="flex justify-end gap-3">
                                                <button type="button"
                                                    onclick="document.getElementById('editModal-{{ $cat->id }}').classList.add('hidden')"
                                                    class="px-4 py-2 rounded border">
                                                    Cancel
                                                </button>
                                                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                                                    Update
                                                </button>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        @empty
                            <tr>
                                <td colspan="5" class="border px-3 py-2 text-center">No categories found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Category Modal -->
    <div id="categoryModal" class="hidden">
        <div class="fixed inset-0 bg-black/20 bg-opacity-50 flex items-center justify-center  z-50">
            <div class="bg-white w-full max-w-lg rounded-md shadow-lg p-6 relative">
                <button onclick="document.getElementById('categoryModal').classList.add('hidden')"
                    class="absolute top-3 right-3 text-gray-500 hover:text-gray-800">
                    ✕
                </button>

                <h2 class="text-xl font-semibold mb-4">Add New Category</h2>

                <form action="{{ route('addAdminCategory') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-gray-700">Category Name</label>
                        <input type="text" name="name"
                            class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div>
                        <label class="block text-gray-700">Description</label>
                        <textarea name="description"
                            class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                    <div>
                        <label class="block text-gray-700">Parent Category</label>
                        <select name="parent_id" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500">
                            <option value="">-- None --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="document.getElementById('categoryModal').classList.add('hidden')"
                            class="px-4 py-2 border rounded-lg text-gray-600 hover:bg-gray-100">
                            Cancel
                        </button>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

   
   

@endsection