<div>
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h1 class="text-2xl font-semibold text-gray-800 mb-6">User Dashboard</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Recent Orders Card -->
            <div class="bg-white border border-gray-100 rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="text-lg font-medium text-gray-800">Recent Orders</div>
                    <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-shopping-bag text-blue-500"></i>
                    </div>
                </div>
                <div class="text-2xl font-bold mb-1">0</div>
                <div class="text-sm text-gray-500">In the last 30 days</div>
            </div>

            <!-- Total Spent Card -->
            <div class="bg-white border border-gray-100 rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="text-lg font-medium text-gray-800">Total Spent</div>
                    <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                        <i class="fas fa-rupee-sign text-green-500"></i>
                    </div>
                </div>
                <div class="text-2xl font-bold mb-1">₹0.00</div>
                <div class="text-sm text-gray-500">Lifetime purchases</div>
            </div>

            <!-- Wishlist Card -->
            <div class="bg-white border border-gray-100 rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="text-lg font-medium text-gray-800">Wishlist</div>
                    <div class="h-10 w-10 rounded-full bg-red-100 flex items-center justify-center">
                        <i class="fas fa-heart text-red-500"></i>
                    </div>
                </div>
                <div class="text-2xl font-bold mb-1">0</div>
                <div class="text-sm text-gray-500">Saved items</div>
            </div>

            <!-- Saved Addresses Card -->
            <div class="bg-white border border-gray-100 rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="text-lg font-medium text-gray-800">Addresses</div>
                    <div class="h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center">
                        <i class="fas fa-map-marker-alt text-purple-500"></i>
                    </div>
                </div>
                <div class="text-2xl font-bold mb-1">0</div>
                <div class="text-sm text-gray-500">Saved addresses</div>
            </div>
        </div>

        <!-- Placeholder for more dashboard content -->
        <div class="mt-8">
            <div class="bg-gray-50 border border-dashed border-gray-200 rounded-lg p-8 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                    <i class="fas fa-shopping-basket text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-1">Start shopping now!</h3>
                <p class="text-gray-500 mb-6">Explore our latest products and add them to your cart.</p>
                <a href="/shop" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-brand-600 hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500">
                    <i class="fas fa-shopping-cart mr-2"></i>
                    Browse Products
                </a>
            </div>
        </div>
    </div>
</div>