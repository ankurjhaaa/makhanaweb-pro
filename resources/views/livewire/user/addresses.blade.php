<div>
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h1 class="text-2xl font-semibold text-gray-800 mb-6">My Addresses</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Add New Address Card -->
            <div class="border border-dashed border-gray-300 rounded-lg p-6 flex flex-col items-center justify-center text-center">
                <div class="h-12 w-12 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                    <i class="fas fa-plus text-gray-500"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-800 mb-2">Add New Address</h3>
                <p class="text-gray-500 mb-4">Add a new shipping or billing address</p>
                <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-brand-600 hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500">
                    Add Address
                </button>
            </div>
            
            <!-- Empty state (remove this when you have actual addresses) -->
            <div class="border border-gray-200 rounded-lg p-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                            <i class="fas fa-home text-blue-600"></i>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <h3 class="text-lg font-medium text-gray-800">Home</h3>
                        <p class="text-gray-500 mt-1">
                            John Doe<br>
                            123 Main Street<br>
                            Apartment 4B<br>
                            New York, NY 10001<br>
                            United States<br>
                            Phone: (123) 456-7890
                        </p>
                        <div class="mt-4 flex items-center space-x-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Default Shipping
                            </span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                Default Billing
                            </span>
                        </div>
                        <div class="mt-4 flex items-center space-x-4">
                            <button type="button" class="text-sm text-brand-600 hover:text-brand-500 font-medium">
                                Edit
                            </button>
                            <button type="button" class="text-sm text-red-600 hover:text-red-500 font-medium">
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>