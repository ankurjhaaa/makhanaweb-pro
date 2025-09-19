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
                        <h3 class="text-2xl font-bold text-gray-800">
                            ₹{{ number_format($totalSales, 2) }}
                        </h3>
                        <p
                            class="flex items-center mt-1 text-xs {{ $salesChange >= 0 ? 'text-green-500' : 'text-red-500' }}">
                            <span>
                                {{ $salesChange >= 0 ? '+' : '' }}{{ $salesChange }}% from last week
                            </span>
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
                        <h3 class="text-2xl font-bold text-gray-800">{{ number_format($totalOrders) }}</h3>
                        <p class="flex items-center mt-1 text-xs {{ $growth >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $growth >= 0 ? '+' : '' }}{{ number_format($growth, 1) }}% from last week
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
                        <p class="text-sm text-gray-500 mb-1">Totle Users</p>
                        <h3 class="text-2xl font-bold text-gray-800">{{$totalUsers}}</h3>
                        <p class="flex items-center mt-1 text-xs text-green-600">
                            <span>+{{$userGrowth}} from last week</span>
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
                        <h3 class="text-2xl font-bold text-gray-800">{{ $totalVariants }}</h3>
                        <p
                            class="flex items-center mt-1 text-xs {{ $variantGrowth >= 0 ? 'text-green-500' : 'text-red-500' }}">
                            <span>
                                {{ $variantGrowth >= 0 ? '+' : '' }}{{ number_format($variantGrowth, 2) }}% from last week
                            </span>
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
                        <p class="text-sm text-gray-500">Last update: {{ now()->format('M d, Y') }}</p>
                    </div>

                    <div class="mt-2 md:mt-0">
                        <form method="GET" action="{{ route('admindashboard') }}">
                            <select name="filter" onchange="this.form.submit()"
                                class="py-1 px-3 border border-gray-300 rounded-md text-sm bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="month" {{ $filter === 'month' ? 'selected' : '' }}>Month</option>
                                <option value="week" {{ $filter === 'week' ? 'selected' : '' }}>Week</option>
                                <option value="year" {{ $filter === 'year' ? 'selected' : '' }}>Year</option>
                            </select>
                        </form>
                    </div>
                </div>

                <!-- Chart -->
                <div class="bg-gray-50 rounded-lg h-60 flex items-center justify-center">
                    <canvas id="ordersChart"></canvas>
                </div>
            </div>

            <!-- Stock Unit (placeholder as in your code) -->
            <div class="bg-white rounded-lg shadow p-5">
                <!-- Header -->
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-base font-semibold text-gray-800">Stock Unit</h3>
                    <select
                        class="py-1 px-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-blue-500">
                        <option>All time</option>
                        <option>This month</option>
                        <option>This year</option>
                    </select>
                </div>

                <!-- Progress Stats -->
                <div class="bg-white rounded-lg shadow p-5">
                    <!-- Header -->
                    {{-- <div class="flex justify-between items-center mb-4">
                        <h3 class="text-base font-semibold text-gray-800">Stock Status</h3>
                        <select
                            class="py-1 px-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-blue-500">
                            <option>All time</option>
                            <option>This month</option>
                            <option>This year</option>
                        </select>
                    </div> --}}

                    <!-- Product Stock Table -->
                    <div class="overflow-x-auto">
                        <div class="max-h-64 overflow-y-auto border rounded-md">
                            <table class="w-full text-sm text-left text-gray-600">
                                <thead class="sticky top-0 bg-gray-100 z-10">
                                    <tr class="border-b">
                                        <th class="py-2 px-2">Product</th>
                                        <th class="py-2 px-2">Available</th>
                                        <th class="py-2 px-2">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                        @php
                                            if ($product->stock == 0) {
                                                $status = 'Out of Stock';
                                                $color = 'text-red-500';
                                            } elseif ($product->stock < 20) {
                                                $status = 'Low Stock';
                                                $color = 'text-yellow-500';
                                            } else {
                                                $status = 'In Stock';
                                                $color = 'text-green-600';
                                            }
                                        @endphp
                                        <tr class="border-b">
                                            <td class="py-2 px-2">{{ $product->name }}</td>
                                            <td class="py-2 px-2">{{ $product->stock }}</td>
                                            <td class="py-2 px-2">
                                                <span class="{{ $color }} font-medium">{{ $status }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>


            </div>

        </div>

        <!-- Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('ordersChart');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($labels),
                    datasets: [{
                        label: 'Orders',
                        data: @json($data),
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.2)',
                        tension: 0.3,
                        fill: true,
                        borderWidth: 2,
                        pointBackgroundColor: '#2563eb',
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1 }
                        }
                    }
                }
            });
        </script>

        <!-- Top Products -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-semibold text-gray-800">Most Selling Products</h3>
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-600">Sort by:</span>
                        <select
                            class="py-1 px-3 border border-gray-300 rounded-md text-sm bg-white shadow-sm focus:outline-none">
                            <option>Most sales</option>
                            <option>Highest rated</option>
                        </select>
                    </div>
                    <a href="{{ route('searchProducts') }}" class="bg-green-600 hover:bg-green-700 text-white 
                                                  py-1 px-2 sm:py-2 sm:px-4 
                                                  rounded-md text-xs sm:text-sm md:text-base 
                                                  flex items-center justify-center gap-1 sm:gap-2">
                        <i class="fas fa-plus text-xs sm:text-sm"></i>
                        <span class="hidden xs:inline">Add products</span>
                    </a>
                </div>
            </div>

            <!-- Dynamic Product cards -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
                @foreach($mostSellingProducts as $item)
                    <div
                        class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition-shadow duration-300">

                        <!-- Image -->
                        <div class="bg-gray-50 h-28 flex items-center justify-center p-2">
                            <img src="{{ $item->product->imagelink }}" alt="{{ $item->product->name }}"
                                class="object-contain h-full w-full">
                        </div>

                        <!-- Product Info -->
                        <div class="p-3 flex flex-col">
                            <h4 class="text-sm font-semibold text-gray-800 truncate" title="{{ $item->product->name }}">
                                {{ $item->product->name }}
                            </h4>
                            <p class="text-xs text-gray-500 mt-1 mb-2">₹{{ number_format($item->product->price, 2) }}</p>

                            <!-- Progress Bar -->
                            <div class="w-full bg-gray-200 rounded-full h-2 mb-2">
                                <div class="bg-green-500 h-2 rounded-full"
                                    style="width: {{ min(100, ($item->total_sold / $mostSellingProducts->max('total_sold')) * 100) }}%">
                                </div>
                            </div>

                            <p class="text-xs text-gray-500 mt-auto">{{ $item->total_sold }} sold</p>
                        </div>
                    </div>
                @endforeach
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
                                <th class="text-left py-3 px-3 text-xs font-medium text-gray-500 uppercase">Order #</th>
                                <th class="text-left py-3 px-3 text-xs font-medium text-gray-500 uppercase">Customer</th>
                                <th class="text-left py-3 px-3 text-xs font-medium text-gray-500 uppercase">Total</th>
                                <th class="text-left py-3 px-3 text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="text-left py-3 px-3 text-xs font-medium text-gray-500 uppercase">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders->take(2) as $order)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-3 px-3 whitespace-nowrap">{{ $order->id }}</td>
                                    <td class="py-3 px-3 whitespace-nowrap"> {{ $order->user->name ?? 'Guest User' }}</td>
                                    <td class="py-3 px-3 whitespace-nowrap">₹{{ number_format($order->total_amount, 2) }}</td>
                                    <td class="py-3 px-3 whitespace-nowrap">
                                        <span
                                            class="px-2 py-1 text-xs rounded-full 
                                                                                                                                                                                {{ $order->status == 'completed' ? 'bg-green-100 text-green-800' : ($order->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-3 whitespace-nowrap text-gray-500">
                                        {{ $order->created_at->format('M d, Y') }}
                                    </td>
                                </tr>
                            @empty
                                <!-- Placeholder Rows -->
                                <tr class="hover:bg-gray-50">
                                    <td class="py-3 px-3">-</td>
                                    <td class="py-3 px-3">No orders yet</td>
                                    <td class="py-3 px-3">₹0.00</td>
                                    <td class="py-3 px-3">
                                        <span class="px-2 py-1 text-xs bg-gray-100 text-gray-500 rounded-full">N/A</span>
                                    </td>
                                    <td class="py-3 px-3 text-gray-500">-</td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="py-3 px-3">-</td>
                                    <td class="py-3 px-3">No orders yet</td>
                                    <td class="py-3 px-3">₹0.00</td>
                                    <td class="py-3 px-3">
                                        <span class="px-2 py-1 text-xs bg-gray-100 text-gray-500 rounded-full">N/A</span>
                                    </td>
                                    <td class="py-3 px-3 text-gray-500">-</td>
                                </tr>
                            @endforelse
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
                                <th class="text-left py-3 px-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name</th>
                                <th class="text-left py-3 px-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Email</th>
                                <th class="text-left py-3 px-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Role</th>
                                <th class="text-left py-3 px-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Joined</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-3 px-3 whitespace-nowrap font-medium">{{ $user->name }}</td>
                                    <td class="py-3 px-3 whitespace-nowrap">{{ $user->email }}</td>
                                    <td class="py-3 px-3 whitespace-nowrap">
                                        <span
                                            class="px-2 py-1 text-xs rounded-full
                                                                                                                        {{ $user->role == 'admin' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-3 whitespace-nowrap text-gray-500">
                                        {{ $user->created_at->format('M d, Y') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection