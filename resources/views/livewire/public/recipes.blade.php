<div class="min-h-screen bg-gradient-to-b from-orange-50 to-white">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-orange-500 to-amber-500 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="font-poppins text-4xl md:text-5xl font-bold mb-4">
                    Makhana Recipes
                </h1>
                <p class="text-xl md:text-2xl text-orange-100 max-w-3xl mx-auto">
                    Discover delicious and healthy recipes with fox nuts (makhana) - from crispy snacks to creamy desserts
                </p>
            </div>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
            <div class="flex flex-col md:flex-row gap-4 items-center">
                <!-- Search -->
                <div class="flex-1 w-full md:w-auto">
                    <div class="relative">
                        <input 
                            type="text" 
                            wire:model.live="searchTerm"
                            placeholder="Search recipes..."
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                        >
                        <svg class="absolute left-3 top-3.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Category Filter -->
                <div class="w-full md:w-auto">
                    <select 
                        wire:model.live="selectedCategory"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                    >
                        <option value="all">All Categories</option>
                        <option value="snacks">Snacks</option>
                        <option value="desserts">Desserts</option>
                        <option value="main-course">Main Course</option>
                        <option value="sides">Sides</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Recipe Count -->
        <div class="mb-6">
            <p class="text-gray-600">
                Showing {{ count($filteredRecipes) }} recipe{{ count($filteredRecipes) !== 1 ? 's' : '' }}
            </p>
        </div>

        <!-- Recipes Grid -->
        @if(count($filteredRecipes) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($filteredRecipes as $recipe)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all duration-300 group">
                        <!-- Recipe Image -->
                        <div class="relative h-48 overflow-hidden">
                            <img 
                                src="{{ $recipe['image'] }}" 
                                alt="{{ $recipe['title'] }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                            >
                            <div class="absolute top-3 right-3">
                                <span class="bg-{{ $recipe['category'] === 'desserts' ? 'pink' : ($recipe['category'] === 'snacks' ? 'yellow' : ($recipe['category'] === 'main-course' ? 'green' : 'blue')) }}-100 text-{{ $recipe['category'] === 'desserts' ? 'pink' : ($recipe['category'] === 'snacks' ? 'yellow' : ($recipe['category'] === 'main-course' ? 'green' : 'blue')) }}-800 px-2 py-1 rounded-full text-xs font-medium capitalize">
                                    {{ str_replace('-', ' ', $recipe['category']) }}
                                </span>
                            </div>
                            <div class="absolute top-3 left-3">
                                <span class="bg-white bg-opacity-90 text-gray-800 px-2 py-1 rounded-full text-xs font-medium">
                                    {{ $recipe['difficulty'] }}
                                </span>
                            </div>
                        </div>

                        <!-- Recipe Content -->
                        <div class="p-6">
                            <h3 class="font-poppins text-xl font-bold text-gray-900 mb-2">{{ $recipe['title'] }}</h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $recipe['description'] }}</p>

                            <!-- Recipe Meta -->
                            <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                                <div class="flex items-center gap-4">
                                    <div class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>{{ $recipe['prep_time'] }}</span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        <span>{{ $recipe['servings'] }}</span>
                                    </div>
                                </div>
                                <span class="text-orange-600 font-medium">{{ $recipe['cook_time'] }}</span>
                            </div>

                            <!-- Expandable Recipe Details -->
                            <div x-data="{ expanded: false }" class="border-t border-gray-100 pt-4">
                                <button 
                                    @click="expanded = !expanded"
                                    class="flex items-center justify-between w-full text-left text-orange-600 hover:text-orange-700 font-medium transition-colors"
                                >
                                    <span>View Recipe</span>
                                    <svg 
                                        x-bind:class="expanded ? 'rotate-180' : ''"
                                        class="w-5 h-5 transition-transform duration-200" 
                                        fill="none" 
                                        stroke="currentColor" 
                                        viewBox="0 0 24 24"
                                    >
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>

                                <div x-show="expanded" x-collapse class="mt-4 space-y-4">
                                    <!-- Ingredients -->
                                    <div>
                                        <h4 class="font-semibold text-gray-900 mb-2">Ingredients:</h4>
                                        <ul class="text-sm text-gray-600 space-y-1">
                                            @foreach($recipe['ingredients'] as $ingredient)
                                                <li class="flex items-start gap-2">
                                                    <span class="w-1.5 h-1.5 bg-orange-500 rounded-full mt-2 flex-shrink-0"></span>
                                                    {{ $ingredient }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>

                                    <!-- Instructions -->
                                    <div>
                                        <h4 class="font-semibold text-gray-900 mb-2">Instructions:</h4>
                                        <ol class="text-sm text-gray-600 space-y-2">
                                            @foreach($recipe['instructions'] as $index => $instruction)
                                                <li class="flex gap-3">
                                                    <span class="flex-shrink-0 w-6 h-6 bg-orange-100 text-orange-800 rounded-full flex items-center justify-center text-xs font-medium">
                                                        {{ $index + 1 }}
                                                    </span>
                                                    {{ $instruction }}
                                                </li>
                                            @endforeach
                                        </ol>
                                    </div>

                                    <!-- Tips -->
                                    @if(isset($recipe['tips']))
                                        <div class="bg-orange-50 border border-orange-200 rounded-lg p-3">
                                            <h4 class="font-semibold text-orange-900 mb-1 flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                                </svg>
                                                Tip:
                                            </h4>
                                            <p class="text-sm text-orange-800">{{ $recipe['tips'] }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- No Results -->
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 20.4a7.962 7.962 0 01-5-1.791M15 11V9a6 6 0 00-12 0v2a4 4 0 00-4 4v5a2 2 0 002 2h14a2 2 0 002-2v-5a4 4 0 00-4-4z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No recipes found</h3>
                <p class="text-gray-500">Try adjusting your search or filter criteria.</p>
            </div>
        @endif
    </div>

    <!-- Call to Action -->
    <div class="bg-gradient-to-r from-orange-500 to-amber-500 text-white py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="font-poppins text-3xl md:text-4xl font-bold mb-4">
                Love Our Recipes?
            </h2>
            <p class="text-xl text-orange-100 mb-8">
                Get premium quality makhana and other healthy snacks delivered to your doorstep
            </p>
            <a 
                href="{{ route('shop') }}" 
                class="inline-flex items-center bg-white text-orange-600 px-8 py-3 rounded-full font-semibold hover:bg-orange-50 transition-colors"
            >
                Shop Now
                <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
        </div>
    </div>
</div>

@push('scripts')
<script src="//unpkg.com/alpinejs" defer></script>
@endpush
