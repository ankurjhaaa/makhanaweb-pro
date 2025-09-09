@extends('admin.layout')

@section('title', 'All Users')

@section('content')
    <div class="bg-white shadow rounded-lg mt-20 p-4">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-gray-800">All Users</h2>
            <a href=""
                class="px-4 py-2 bg-blue-600 text-white rounded-md shadow hover:bg-blue-700 transition font-semibold text-sm">
                + Add User
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">First Name</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Last Name</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Google ID</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Avatar</th>
                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($allUsers as $user)
                        <tr>
                            <td class="px-4 py-2 whitespace-nowrap">{{ $user->name }}</td>
                            <td class="px-4 py-2 whitespace-nowrap">{{ $user->first_name }}</td>
                            <td class="px-4 py-2 whitespace-nowrap">{{ $user->last_name }}</td>
                            <td class="px-4 py-2 whitespace-nowrap">{{ $user->email }}</td>
                            <td class="px-4 py-2 whitespace-nowrap">{{ $user->role }}</td>
                            <td class="px-4 py-2 whitespace-nowrap">{{ $user->google_id ?? '-' }}</td>
                            <td class="px-4 py-2 whitespace-nowrap">
                                @if($user->avatar)
                                    <img src="{{ asset('storage/avatars/' . $user->avatar) }}" alt="Avatar"
                                        class="w-10 h-10 rounded-full object-cover">
                                @else
                                    <span class="text-gray-400">N/A</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 whitespace-nowrap text-center">
                                <a href="" class="text-yellow-500 hover:underline mr-2">Edit</a>
                                <form action="" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline"
                                        onclick="return confirm('Are you sure?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-4 py-6 text-center text-gray-500">
                                No users found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>


    </div>
@endsection