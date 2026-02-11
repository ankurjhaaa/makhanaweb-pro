<div class="space-y-8">

    <!-- Header -->
    <div class="bg-white border border-gray-100 rounded-lg shadow-sm p-6">
        <h1 class="font-poppins text-2xl font-semibold text-gray-800">
            Dashboard
        </h1>
        <p class="text-sm text-gray-500 mt-1">
            Welcome back, {{ auth()->user()->name }}
        </p>
    </div>


    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-4">

        <!-- Recent Orders -->
        <div class="bg-white border border-gray-100 rounded-lg shadow-sm p-5 hover:shadow-md transition">
            <div class="flex items-center justify-between mb-4">
                <div class="text-sm text-gray-500">
                    Recent Orders
                </div>
                <div class="h-10 w-10 rounded-full bg-blue-50 flex items-center justify-center">
                    <i class="fas fa-shopping-bag text-brand-600"></i>
                </div>
            </div>

            <div class="text-2xl font-semibold text-gray-800">
                {{ $recentOrders ?? 0 }}
            </div>
            <div class="text-xs text-gray-400 mt-1">
                Last 30 days
            </div>
        </div>


        <!-- Total Spent -->
        <div class="bg-white border border-gray-100 rounded-lg shadow-sm p-5 hover:shadow-md transition">
            <div class="flex items-center justify-between mb-4">
                <div class="text-sm text-gray-500">
                    Total Spent
                </div>
                <div class="h-10 w-10 rounded-full bg-green-50 flex items-center justify-center">
                    <i class="fas fa-rupee-sign text-brand-600"></i>
                </div>
            </div>

            <div class="text-2xl font-semibold text-gray-800">
                ₹{{ number_format($totalSpent ?? 0, 2) }}
            </div>
            <div class="text-xs text-gray-400 mt-1">
                Lifetime purchases
            </div>
        </div>


        <!-- Wishlist -->
        <div class="bg-white border border-gray-100 rounded-lg shadow-sm p-5 hover:shadow-md transition">
            <div class="flex items-center justify-between mb-4">
                <div class="text-sm text-gray-500">
                    Wishlist
                </div>
                <div class="h-10 w-10 rounded-full bg-red-50 flex items-center justify-center">
                    <i class="fas fa-heart text-brand-600"></i>
                </div>
            </div>

            <div class="text-2xl font-semibold text-gray-800">
                {{ $wishlistCount ?? 0 }}
            </div>
            <div class="text-xs text-gray-400 mt-1">
                Saved items
            </div>
        </div>


        <!-- Addresses -->
        <div class="bg-white border border-gray-100 rounded-lg shadow-sm p-5 hover:shadow-md transition">
            <div class="flex items-center justify-between mb-4">
                <div class="text-sm text-gray-500">
                    Addresses
                </div>
                <div class="h-10 w-10 rounded-full bg-purple-50 flex items-center justify-center">
                    <i class="fas fa-map-marker-alt text-brand-600"></i>
                </div>
            </div>

            <div class="text-2xl font-semibold text-gray-800">
                {{ $addressesCount ?? 0 }}
            </div>
            <div class="text-xs text-gray-400 mt-1">
                Saved addresses
            </div>
        </div>

    </div>


    <!-- Action Section -->
    <div class="bg-white border border-gray-100 rounded-lg shadow-sm p-6">

        <h2 class="font-poppins text-lg font-semibold text-gray-800 mb-6">
            Quick Actions
        </h2>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

            <a href="{{ route('user.orders') }}"
                class="border border-gray-100 rounded-lg p-4 text-center hover:bg-gray-50 transition">
                <i class="fas fa-box text-brand-600 text-lg mb-2"></i>
                <div class="text-sm font-medium text-gray-700">
                    My Orders
                </div>
            </a>

            <a href="{{ route('user.wishlist') }}"
                class="border border-gray-100 rounded-lg p-4 text-center hover:bg-gray-50 transition">
                <i class="fas fa-heart text-brand-600 text-lg mb-2"></i>
                <div class="text-sm font-medium text-gray-700">
                    Wishlist
                </div>
            </a>

            <a href="{{ route('user.addresses') }}"
                class="border border-gray-100 rounded-lg p-4 text-center hover:bg-gray-50 transition">
                <i class="fas fa-map-marker-alt text-brand-600 text-lg mb-2"></i>
                <div class="text-sm font-medium text-gray-700">
                    Addresses
                </div>
            </a>

            <a href="{{ route('user.profile') }}"
                class="border border-gray-100 rounded-lg p-4 text-center hover:bg-gray-50 transition">
                <i class="fas fa-user text-brand-600 text-lg mb-2"></i>
                <div class="text-sm font-medium text-gray-700">
                    Profile
                </div>
            </a>

        </div>

    </div>

</div>