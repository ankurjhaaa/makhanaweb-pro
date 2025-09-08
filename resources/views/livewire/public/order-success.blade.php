<div class="bg-white text-gray-800">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 py-16 text-center">
        <!-- Success Icon -->
        <div class="text-brand-600 text-6xl mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        
        <!-- Success Message -->
        <h1 class="font-poppins text-4xl font-bold mb-4">Order Placed Successfully!</h1>
        <p class="text-gray-600 text-lg mb-8 max-w-2xl mx-auto">
            Thank you for your order! We've received your order and will begin processing it shortly. 
            You'll receive an email confirmation with your order details and tracking information.
        </p>
        
        <!-- Order Details -->
        <div class="bg-gray-50 rounded-lg p-6 mb-8 max-w-md mx-auto">
            <h2 class="font-semibold mb-2">Order Details</h2>
            <div class="text-sm text-gray-600">
                <div class="flex justify-between mb-1">
                    <span>Order Number:</span>
                    <span class="font-medium">#{{ rand(100000, 999999) }}</span>
                </div>
                <div class="flex justify-between mb-1">
                    <span>Estimated Delivery:</span>
                    <span class="font-medium">{{ now()->addDays(3)->format('M d, Y') }}</span>
                </div>
                @if(session('success'))
                    <div class="mt-4 text-brand-600 text-sm">
                        {{ session('success') }}
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="/" class="bg-brand-600 text-white px-6 py-3 rounded-full hover:bg-brand-700 transition-all font-medium">
                Continue Shopping
            </a>
            <a href="#" class="border border-gray-300 text-gray-700 px-6 py-3 rounded-full hover:border-brand-600 hover:text-brand-600 transition-all font-medium">
                Track Order
            </a>
        </div>
    </div>
</div>