<div>
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h1 class="text-2xl font-semibold text-gray-800 mb-6">My Profile</h1>

        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- Profile Update Form -->
        <form wire:submit.prevent="updateProfile" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                    <input 
                        type="text" 
                        wire:model.defer="first_name"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md text-sm focus:ring-brand-500 focus:border-brand-500"
                    >
                    @error('first_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                    <input 
                        type="text" 
                        wire:model.defer="last_name"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md text-sm focus:ring-brand-500 focus:border-brand-500"
                    >
                    @error('last_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                    <input 
                        type="email"
                        wire:model="email"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md text-sm focus:ring-brand-500 focus:border-brand-500 bg-gray-100"
                        disabled
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                    <input 
                        type="tel"
                        wire:model.defer="phone"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md text-sm focus:ring-brand-500 focus:border-brand-500"
                    >
                    @error('phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="pt-5">
                <div class="flex justify-end">
                    <button 
                        type="submit"
                        class="inline-flex items-center px-4 py-2 rounded-md text-sm font-medium bg-gray-300 text-white bg-brand-600 hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500"
                    >
                        Update Profile
                    </button>
                </div>
            </div>
        </form>

        <hr class="my-8">

        <!-- Password change section -->
        <h2 class="text-xl font-semibold text-gray-800 mb-6">Change Password</h2>

        <form wire:submit.prevent="changePassword" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                    <input 
                        type="password"
                        wire:model.defer="current_password"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md text-sm focus:ring-brand-500 focus:border-brand-500"
                    >
                    @error('current_password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                        <input 
                            type="password"
                            wire:model.defer="new_password"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md text-sm focus:ring-brand-500 focus:border-brand-500"
                        >
                        @error('new_password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                        <input 
                            type="password"
                            wire:model.defer="new_password_confirmation"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md text-sm focus:ring-brand-500 focus:border-brand-500"
                        >
                    </div>
                </div>
            </div>

            <div class="pt-5">
                <div class="flex justify-end">
                    <button 
                        type="submit"
                        class="inline-flex items-center px-4 py-2 rounded-md text-sm font-medium text-white bg-brand-600 hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500"
                    >
                        Change Password
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
