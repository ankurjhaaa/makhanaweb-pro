<div class="space-y-8">

    <!-- Header -->
    <div class="bg-white border border-gray-100 rounded-lg shadow-sm p-6">
        <h1 class="font-poppins text-2xl font-semibold text-gray-800">
            My Profile
        </h1>
        <p class="text-sm text-gray-500 mt-1">
            Manage your account information
        </p>
    </div>



    @if (session('success'))
        <div class="p-4 bg-green-50 border border-green-100 text-green-700 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif



    <!-- Profile Information -->
    <div class="bg-white border border-gray-100 rounded-lg shadow-sm p-6">

        <h2 class="font-poppins text-lg font-semibold text-gray-800 mb-6">
            Personal Information
        </h2>

        <form wire:submit.prevent="updateProfile" class="space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- First Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        First Name
                    </label>
                    <input type="text" wire:model.defer="first_name"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-md text-sm focus:ring-brand-500 focus:border-brand-500">
                    @error('first_name')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Last Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Last Name
                    </label>
                    <input type="text" wire:model.defer="last_name"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-md text-sm focus:ring-brand-500 focus:border-brand-500">
                    @error('last_name')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Email Address
                    </label>
                    <input type="email" wire:model="email" disabled
                        class="w-full px-4 py-2.5 border border-gray-200 bg-gray-50 rounded-md text-sm text-gray-500">
                </div>

                <!-- Phone -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Phone Number
                    </label>
                    <input type="tel" wire:model.defer="phone"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-md text-sm focus:ring-brand-500 focus:border-brand-500">
                    @error('phone')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="px-6 py-2.5 bg-gray-600 text-white text-sm font-medium rounded-md hover:bg-brand-700 transition focus:ring-2 focus:ring-brand-500 focus:ring-offset-2">
                    Save Changes
                </button>
            </div>

        </form>

    </div>



    <!-- Change Password Section -->
    <div class="bg-white border border-gray-100 rounded-lg shadow-sm p-6">

        <h2 class="font-poppins text-lg font-semibold text-gray-800 mb-6">
            Change Password
        </h2>

        <form wire:submit.prevent="changePassword" class="space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- New Password -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        New Password
                    </label>
                    <input type="password" wire:model.defer="new_password"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-md text-sm focus:ring-brand-500 focus:border-brand-500">
                    @error('new_password')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Confirm New Password
                    </label>
                    <input type="password" wire:model.defer="new_password_confirmation"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-md text-sm focus:ring-brand-500 focus:border-brand-500">
                </div>

            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="px-6 py-2.5 bg-gray-600 text-white text-sm font-medium rounded-md hover:bg-brand-700 transition focus:ring-2 focus:ring-brand-500 focus:ring-offset-2">
                    Update Password
                </button>
            </div>

        </form>

    </div>

</div>