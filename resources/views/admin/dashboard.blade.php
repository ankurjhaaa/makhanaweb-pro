@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
    <div class="mt-20">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <div class="bg-white shadow rounded-lg p-4 flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Users</p>
                    <p class="text-2xl font-bold text-gray-800">80</p>
                </div>
                <div class="text-gray-400">
                    <i class="fas fa-users fa-2x"></i>
                </div>
            </div>

            <div class="bg-white shadow rounded-lg p-4 flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Orders</p>
                    <p class="text-2xl font-bold text-gray-800">80</p>
                </div>
                <div class="text-gray-400">
                    <i class="fas fa-shopping-cart fa-2x"></i>
                </div>
            </div>

            <div class="bg-white shadow rounded-lg p-4 flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Products</p>
                    <p class="text-2xl font-bold text-gray-800">103</p>
                </div>
                <div class="text-gray-400">
                    <i class="fas fa-box fa-2x"></i>
                </div>
            </div>

            <div class="bg-white shadow rounded-lg p-4 flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Revenue</p>
                    <p class="text-2xl font-bold text-gray-800"> ₹ 9999</p>
                </div>
                <div class="text-gray-400">
                    <i class="fas fa-rupee-sign fa-2x"></i>
                </div>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg p-4 mb-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Recent Orders</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Order #</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">User ID</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-4 py-2 whitespace-nowrap">4</td>
                            <td class="px-4 py-2 whitespace-nowrap">4</td>
                            <td class="px-4 py-2 whitespace-nowrap">500.00</td>
                            <td class="px-4 py-2 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs bg-green-200 text-green-800 rounded-full">
                                    success
                                </span>
                            </td>
                            <td class="px-4 py-2 whitespace-nowrap">3 jun 3033</td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Users -->
        <div class="bg-white shadow rounded-lg p-4 mb-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Recent Users</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Joined</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-4 py-2 whitespace-nowrap">Ankur Jha</td>
                            <td class="px-4 py-2 whitespace-nowrap">akj41731@gmail.com</td>
                            <td class="px-4 py-2 whitespace-nowrap">admin</td>
                            <td class="px-4 py-2 whitespace-nowrap">5 may 2024</td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection