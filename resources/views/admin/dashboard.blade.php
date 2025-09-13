@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
    <div class="pt-8 pb-4">
        <!-- Welcome section -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Hi Mac,</h1>
            <p class="text-gray-600">Welcome back to your dashboard</p>
        </div>

        <!-- Stats cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
            <!-- Total Sales Card -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all stat-card">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Total Sales</p>
                        <h3 class="text-2xl font-bold text-gray-800">₹8,245.00</h3>
                        <p class="flex items-center mt-1 text-xs text-red-500">
                            <span>-0.5% from last week</span>
                        </p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <i class="fas fa-rupee-sign text-green-600"></i>
                    </div>
                </div>
            </div>

            <!-- Total Orders Card -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all stat-card">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Total Orders</p>
                        <h3 class="text-2xl font-bold text-gray-800">1,256</h3>
                        <p class="flex items-center mt-1 text-xs text-green-600">
                            <span>+1.0% from last week</span>
                        </p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full">
                        <i class="fas fa-shopping-cart text-blue-600"></i>
                    </div>
                </div>
            </div>

            <!-- Net Sales Card -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all stat-card">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Net Sales</p>
                        <h3 class="text-2xl font-bold text-gray-800">₹431.00</h3>
                        <p class="flex items-center mt-1 text-xs text-green-600">
                            <span>+1.0% from last week</span>
                        </p>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-full">
                        <i class="fas fa-chart-line text-purple-600"></i>
                    </div>
                </div>
            </div>

            <!-- Stock Units Card -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all stat-card">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Total Variants</p>
                        <h3 class="text-2xl font-bold text-gray-800">456K</h3>
                        <p class="flex items-center mt-1 text-xs text-red-500">
                            <span>-25% from last week</span>
                        </p>
                    </div>
                    <div class="bg-orange-100 p-3 rounded-full">
                        <i class="fas fa-eye text-orange-600"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts and Tables -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Order Overview -->
            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex flex-wrap justify-between items-center mb-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Total Order Overview</h3>
                        <p class="text-sm text-gray-500">Last update: May 12, 2024</p>
                    </div>
                    
                    <div class="mt-2 md:mt-0">
                        <select class="py-1 px-3 border border-gray-300 rounded-md text-sm bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option>Month</option>
                            <option>Week</option>
                            <option>Year</option>
                        </select>
                    </div>
                </div>
                
                <!-- Chart placeholder - in a real app, you'd use a JS chart library here -->
                <div class="bg-gray-100 rounded-lg h-60 flex items-center justify-center">
                    <p class="text-gray-500">Order statistics chart would appear here</p>
                </div>
            </div>

            <!-- Stock Unit -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex flex-wrap justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">Stock Unit</h3>
                    <div class="mt-2 md:mt-0">
                        <select class="py-1 px-3 border border-gray-300 rounded-md text-sm bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option>All time</option>
                            <option>This month</option>
                            <option>This year</option>
                        </select>
                    </div>
                </div>
                
                <!-- Donut chart placeholder -->
                <div class="relative h-52 w-52 mx-auto">
                    <!-- This would be replaced with an actual chart in a real implementation -->
                    <div class="rounded-full h-full w-full border-8 border-l-green-600 border-r-yellow-400 border-t-red-500 border-b-green-600 rotate-45"></div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="bg-white h-32 w-32 rounded-full"></div>
                    </div>
                </div>
                
                <!-- Chart legend -->
                <div class="mt-6 grid grid-cols-3 gap-2 text-center">
                    <div>
                        <div class="flex items-center justify-center gap-1">
                            <span class="h-3 w-3 rounded-full bg-green-600 inline-block"></span>
                            <span class="text-xs text-gray-600">Production</span>
                        </div>
                        <p class="text-sm font-medium">50%</p>
                    </div>
                    <div>
                        <div class="flex items-center justify-center gap-1">
                            <span class="h-3 w-3 rounded-full bg-yellow-400 inline-block"></span>
                            <span class="text-xs text-gray-600">Store</span>
                        </div>
                        <p class="text-sm font-medium">20%</p>
                    </div>
                    <div>
                        <div class="flex items-center justify-center gap-1">
                            <span class="h-3 w-3 rounded-full bg-red-500 inline-block"></span>
                            <span class="text-xs text-gray-600">Stock</span>
                        </div>
                        <p class="text-sm font-medium">30%</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Top Products -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-semibold text-gray-800">Most Selling Products</h3>
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-600">Sort by:</span>
                        <select class="py-1 px-3 border border-gray-300 rounded-md text-sm bg-white shadow-sm focus:outline-none">
                            <option>Most sales</option>
                            <option>Highest rated</option>
                        </select>
                    </div>
                    <button class="bg-green-600 hover:bg-green-700 text-white py-1 px-3 rounded-md text-sm flex items-center gap-1">
                        <i class="fas fa-plus"></i> Add products
                    </button>
                </div>
            </div>
            
            <!-- Product cards -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4">
                <!-- Product card 1 -->
                <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition-all">
                    <div class="bg-yellow-100 h-24 flex items-center justify-center">
                        <i class="fas fa-headphones text-2xl text-yellow-600"></i>
                    </div>
                    <div class="p-3">
                        <h4 class="text-sm font-medium truncate">Wireless Headphones</h4>
                        <p class="text-xs text-gray-500 mb-1">₹499.99</p>
                        <div class="h-1 w-full bg-gray-200 rounded-full overflow-hidden">
                            <div class="bg-green-500 h-full" style="width: 75%"></div>
                        </div>
                    </div>
                </div>
                
                <!-- Product card 2 -->
                <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition-all">
                    <div class="bg-blue-100 h-24 flex items-center justify-center">
                        <i class="fas fa-glasses text-2xl text-blue-600"></i>
                    </div>
                    <div class="p-3">
                        <h4 class="text-sm font-medium truncate">Sunglasses</h4>
                        <p class="text-xs text-gray-500 mb-1">₹299.99</p>
                        <div class="h-1 w-full bg-gray-200 rounded-full overflow-hidden">
                            <div class="bg-green-500 h-full" style="width: 60%"></div>
                        </div>
                    </div>
                </div>
                
                <!-- More product cards would be here -->
                <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition-all">
                    <div class="bg-purple-100 h-24 flex items-center justify-center">
                        <i class="fas fa-camera text-2xl text-purple-600"></i>
                    </div>
                    <div class="p-3">
                        <h4 class="text-sm font-medium truncate">Camera</h4>
                        <p class="text-xs text-gray-500 mb-1">₹799.99</p>
                        <div class="h-1 w-full bg-gray-200 rounded-full overflow-hidden">
                            <div class="bg-green-500 h-full" style="width: 40%"></div>
                        </div>
                    </div>
                </div>
                
                <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition-all">
                    <div class="bg-red-100 h-24 flex items-center justify-center">
                        <i class="fas fa-tshirt text-2xl text-red-600"></i>
                    </div>
                    <div class="p-3">
                        <h4 class="text-sm font-medium truncate">Hoodie</h4>
                        <p class="text-xs text-gray-500 mb-1">₹149.99</p>
                        <div class="h-1 w-full bg-gray-200 rounded-full overflow-hidden">
                            <div class="bg-green-500 h-full" style="width: 25%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Tables grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Orders -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Orders</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-3 px-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Order #</th>
                                <th class="text-left py-3 px-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                <th class="text-left py-3 px-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                <th class="text-left py-3 px-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="text-left py-3 px-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 px-3 whitespace-nowrap">4</td>
                                <td class="py-3 px-3 whitespace-nowrap">John Doe</td>
                                <td class="py-3 px-3 whitespace-nowrap">₹500.00</td>
                                <td class="py-3 px-3 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">
                                        Completed
                                    </span>
                                </td>
                                <td class="py-3 px-3 whitespace-nowrap text-gray-500">Jun 3, 2024</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 px-3 whitespace-nowrap">5</td>
                                <td class="py-3 px-3 whitespace-nowrap">Jane Smith</td>
                                <td class="py-3 px-3 whitespace-nowrap">₹750.00</td>
                                <td class="py-3 px-3 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">
                                        Pending
                                    </span>
                                </td>
                                <td class="py-3 px-3 whitespace-nowrap text-gray-500">Jun 5, 2024</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Recent Users -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Users</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-3 px-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="text-left py-3 px-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="text-left py-3 px-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                <th class="text-left py-3 px-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 px-3 whitespace-nowrap font-medium">Ankur Jha</td>
                                <td class="py-3 px-3 whitespace-nowrap">akj41731@gmail.com</td>
                                <td class="py-3 px-3 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">
                                        Admin
                                    </span>
                                </td>
                                <td class="py-3 px-3 whitespace-nowrap text-gray-500">May 5, 2024</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 px-3 whitespace-nowrap font-medium">Mac Gibson</td>
                                <td class="py-3 px-3 whitespace-nowrap">mac@example.com</td>
                                <td class="py-3 px-3 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded-full">
                                        Customer
                                    </span>
                                </td>
                                <td class="py-3 px-3 whitespace-nowrap text-gray-500">May 10, 2024</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection