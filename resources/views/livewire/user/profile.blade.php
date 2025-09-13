<div>
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h1 class="text-2xl font-semibold text-gray-800 mb-6">My Profile</h1>
        
        <!-- Profile form placeholder -->
        <form class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        First Name
                    </label>
                    <input 
                        type="text"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md text-sm focus:ring-brand-500 focus:border-brand-500"
                    >
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Last Name
                    </label>
                    <input 
                        type="text"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md text-sm focus:ring-brand-500 focus:border-brand-500"
                    >
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Email Address
                    </label>
                    <input 
                        type="email"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md text-sm focus:ring-brand-500 focus:border-brand-500"
                        disabled
                    >
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Phone Number
                    </label>
                    <input 
                        type="tel"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md text-sm focus:ring-brand-500 focus:border-brand-500"
                    >
                </div>
            </div>

            <div class="pt-5">
                <div class="flex justify-end">
                    <button 
                        type="button"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-brand-600 hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500"
                    >
                        Update Profile
                    </button>
                </div>
            </div>
        </form>
        
        <hr class="my-8">
        
        <!-- Password change section -->
        <h2 class="text-xl font-semibold text-gray-800 mb-6">Change Password</h2>
        
        <form class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Current Password
                    </label>
                    <input 
                        type="password"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md text-sm focus:ring-brand-500 focus:border-brand-500"
                    >
                </div>
                
                <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            New Password
                        </label>
                        <input 
                            type="password"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md text-sm focus:ring-brand-500 focus:border-brand-500"
                        >
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Confirm New Password
                        </label>
                        <input 
                            type="password"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md text-sm focus:ring-brand-500 focus:border-brand-500"
                        >
                    </div>
                </div>
            </div>

            <div class="pt-5">
                <div class="flex justify-end">
                    <button 
                        type="button"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-brand-600 hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500"
                    >
                        Change Password
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>