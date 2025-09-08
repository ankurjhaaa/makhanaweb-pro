@extends('admin.layout')

@section('title','Manage Categories')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Categories</h1>
        <a href="#" 
           class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            + Add Category
        </a>
    </div>

    {{-- Categories Table --}}
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full table-auto">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="px-6 py-3 text-sm font-medium text-gray-700">#</th>
                    <th class="px-6 py-3 text-sm font-medium text-gray-700">Name</th>
                    <th class="px-6 py-3 text-sm font-medium text-gray-700">Parent</th>
                    <th class="px-6 py-3 text-sm font-medium text-gray-700">Created At</th>
                    <th class="px-6 py-3 text-sm font-medium text-gray-700 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">

                {{-- Static Row 1 --}}
                <tr>
                  
                      
                </tr>

                {{-- Static Row 2 --}}
                <tr>
                    
                </tr>

                {{-- Static Row 3 --}}
                <tr>
                   
                </tr>

            </tbody>
        </table>
    </div>
@endsection
