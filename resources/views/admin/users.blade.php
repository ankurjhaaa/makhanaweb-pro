@extends('admin.layout')

@section('title', 'All Users')

@section('content')
    <div class="pt-8 pb-4">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Users</h1>
                <p class="text-gray-600 mt-1">Manage customer accounts and admin users</p>
            </div>
            
            <div class="mt-4 md:mt-0">
                <button id="openUserModal"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md shadow flex items-center gap-2">
                    <i class="fas fa-plus"></i>
                    <span>Add User</span>
                </button>
            </div>
        </div>

        <div class="bg-white shadow-sm border border-gray-200 rounded-xl overflow-hidden">
            <div class="p-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 gap-4">
                    <div class="relative w-full md:w-96">
                        <input type="text" placeholder="Search users..." 
                            class="py-2 pl-10 pr-4 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full text-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        <label for="user-filter" class="text-sm text-gray-600">Filter by:</label>
                        <select id="user-filter"
                            class="text-sm border border-gray-300 rounded-md px-3 py-2 bg-white focus:ring-blue-500 focus:border-blue-500">
                            <option value="all">All Users</option>
                            <option value="admin">Admins</option>
                            <option value="customer">Customers</option>
                            <option value="google">Google Sign-in</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Auth Method</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($allUsers as $user)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        @if($user->avatar)
                                            <img src="{{ asset('storage/avatars/' . $user->avatar) }}" alt="Avatar"
                                                class="h-10 w-10 rounded-full object-cover border border-gray-200">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                <span class="text-blue-600 font-medium text-sm">{{ substr($user->first_name ?? $user->name, 0, 1) }}{{ substr($user->last_name, 0, 1) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $user->first_name }} {{ $user->last_name }}
                                        </div>
                                        <div class="text-sm text-gray-500">{{ $user->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($user->role == 'admin')
                                    <span class="px-2 py-1 text-xs bg-purple-100 text-purple-800 rounded-full">
                                        Admin
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">
                                        Customer
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($user->google_id)
                                    <div class="flex items-center">
                                        <i class="fab fa-google text-red-500 mr-2"></i>
                                        <span class="text-sm text-gray-700">Google</span>
                                    </div>
                                @else
                                    <div class="flex items-center">
                                        <i class="fas fa-envelope text-gray-500 mr-2"></i>
                                        <span class="text-sm text-gray-700">Email</span>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $user->created_at ? $user->created_at->format('M d, Y') : 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="flex items-center justify-end space-x-3">
                                    
                                    <form action="{{ route('deleteUser', $user->id ?? 0) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure you want to delete this user?')"
                                            class="text-red-600 hover:text-red-900" title="Delete User">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-users text-gray-300 text-5xl mb-4"></i>
                                    <p class="text-lg font-medium text-gray-600">No users found</p>
                                    <p class="text-gray-400 mt-1">Create a user or adjust your search filters</p>
                                    <button id="openEmptyUserModal" 
                                        class="mt-4 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md flex items-center gap-2">
                                        <i class="fas fa-plus"></i>
                                        <span>Add User</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if(count($allUsers) > 0)
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-600">Showing {{ count($allUsers) }} users</p>
                <!-- Pagination could be added here if needed -->
            </div>
        </div>
        @endif
    </div>
</div>
    {{-- Add User Modal --}}
    <div id="userModal" class="hidden">
        <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm flex justify-center items-center z-50 p-4">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg relative">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-bold text-gray-800">Add New User</h2>
                        <button id="closeUserModal"
                            class="text-gray-400 hover:text-gray-600 focus:outline-none">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <div class="p-6">
                    <form action="{{ route('addUser') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                        @csrf
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                                <input type="text" name="first_name" placeholder="Enter first name"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500"
                                    required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                                <input type="text" name="last_name" placeholder="Enter last name"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500"
                                    required>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                                <input type="text" name="name" placeholder="Enter username"
                                    class="w-full border border-gray-300 pl-10 px-4 py-2 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                    required>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-gray-400"></i>
                                </div>
                                <input type="email" name="email" placeholder="user@example.com"
                                    class="w-full border border-gray-300 pl-10 px-4 py-2 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                    required>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input type="password" name="password" placeholder="Enter password"
                                    class="w-full border border-gray-300 pl-10 px-4 py-2 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                    required>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Password must be at least 8 characters long</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                            <div class="relative">
                                <select name="role"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white focus:ring-blue-500 focus:border-blue-500 appearance-none"
                                    required>
                                    <option value="customer">Customer</option>
                                    <option value="admin">Admin</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Profile Image (Optional)</label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-4">
                                <div class="text-center">
                                    <i class="fas fa-user-circle text-gray-400 text-3xl mb-2"></i>
                                    <p class="text-sm text-gray-500 mb-1">Upload a profile picture or</p>
                                    <label class="cursor-pointer inline-block">
                                        <span class="text-sm text-blue-600 hover:text-blue-700">Browse files</span>
                                        <input type="file" name="avatar" class="hidden" accept="image/*">
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-gray-200 flex justify-end gap-3">
                            <button type="button" id="cancelUserBtn"
                                class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300">
                                Cancel
                            </button>
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                Create User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit User Modal Template - Would need to be populated dynamically with user data --}}
    <div id="editUserModal" class="hidden">
        <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm flex justify-center items-center z-50 p-4">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg relative">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-bold text-gray-800">Edit User</h2>
                        <button id="closeEditUserModal"
                            class="text-gray-400 hover:text-gray-600 focus:outline-none">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <div class="p-6">
                    <form id="editUserForm" action="" method="POST" enctype="multipart/form-data" class="space-y-5">
                        @csrf
                        @method('PUT')
                        
                        <!-- Similar fields as add user form but with ID values populated dynamically -->
                        
                        <div class="pt-4 border-t border-gray-200 flex justify-end gap-3">
                            <button type="button" id="cancelEditBtn"
                                class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300">
                                Cancel
                            </button>
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                Update User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Add User Modal Controls
        const userModal = document.getElementById('userModal');
        const openUserModal = document.getElementById('openUserModal');
        const closeUserModal = document.getElementById('closeUserModal');
        const cancelUserBtn = document.getElementById('cancelUserBtn');
        const openEmptyUserModal = document.getElementById('openEmptyUserModal');

        // Function to open modal
        function openUserModalFunc() {
            userModal.classList.remove('hidden');
            userModal.classList.add('flex');
        }

        // Function to close modal
        function closeUserModalFunc() {
            userModal.classList.add('hidden');
            userModal.classList.remove('flex');
        }

        // Add event listeners
        if (openUserModal) {
            openUserModal.addEventListener('click', openUserModalFunc);
        }
        
        if (openEmptyUserModal) {
            openEmptyUserModal.addEventListener('click', openUserModalFunc);
        }
        
        closeUserModal.addEventListener('click', closeUserModalFunc);
        cancelUserBtn.addEventListener('click', closeUserModalFunc);

        // Close when clicking outside modal
        window.addEventListener('click', (e) => {
            if (e.target === userModal) {
                closeUserModalFunc();
            }
        });

        // Edit User Modal Functions
        function openEditUserModal(userId) {
            // Here you would fetch user data and populate the form fields
            // For this example, we'll just show the modal
            document.getElementById('editUserModal').classList.remove('hidden');
            document.getElementById('editUserModal').classList.add('flex');
            
            // Update the form action URL with the user ID
            document.getElementById('editUserForm').action = `/admin/users/${userId}`;
        }

        document.getElementById('closeEditUserModal').addEventListener('click', () => {
            document.getElementById('editUserModal').classList.add('hidden');
            document.getElementById('editUserModal').classList.remove('flex');
        });

        document.getElementById('cancelEditBtn').addEventListener('click', () => {
            document.getElementById('editUserModal').classList.add('hidden');
            document.getElementById('editUserModal').classList.remove('flex');
        });
    </script>
@endsection