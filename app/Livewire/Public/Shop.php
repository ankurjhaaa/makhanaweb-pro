<?php

namespace App\Livewire\Public;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class Shop extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedCategory = 'All';
    public $sortBy = 'name';
    public $products = [];
    public $categories = ['All', 'Makhana', 'Spices', 'Healthy Snacks', 'Nuts & Seeds'];

    public function mount()
    {
        $this->loadProducts();
    }

    public function loadProducts()
    {
        // Sample products data (in real app, this would come from database)
        $this->products = [
            [
                'id' => 1,
                'name' => 'Premium Roasted Makhana',
                'category' => 'Makhana',
                'price' => 299,
                'original_price' => 399,
                'image' => '/images/makhana1.jpg',
                'rating' => 4.8,
                'reviews' => 124,
                'tag' => 'Best Seller',
                'tag_color' => 'bg-green-500',
                'in_stock' => true,
                'description' => 'Premium quality lotus seeds roasted to perfection'
            ],
            [
                'id' => 2,
                'name' => 'Organic Turmeric Powder',
                'category' => 'Spices',
                'price' => 199,
                'original_price' => 249,
                'image' => '/images/turmeric.jpg',
                'rating' => 4.6,
                'reviews' => 89,
                'tag' => 'Premium',
                'tag_color' => 'bg-blue-500',
                'in_stock' => true,
                'description' => 'Pure organic turmeric powder for health'
            ],
            [
                'id' => 3,
                'name' => 'Healthy Mix Snacks',
                'category' => 'Healthy Snacks',
                'price' => 349,
                'original_price' => 449,
                'image' => '/images/mix-snacks.jpg',
                'rating' => 4.7,
                'reviews' => 156,
                'tag' => 'Popular',
                'tag_color' => 'bg-orange-500',
                'in_stock' => true,
                'description' => 'Mix of nuts, seeds, and healthy snacks'
            ],
            [
                'id' => 4,
                'name' => 'Flavoured Makhana Combo',
                'category' => 'Makhana',
                'price' => 549,
                'original_price' => 699,
                'image' => '/images/makhana-combo.jpg',
                'rating' => 4.8,
                'reviews' => 203,
                'tag' => 'Combo',
                'tag_color' => 'bg-purple-500',
                'in_stock' => true,
                'description' => 'Pack of 3 different flavored makhana'
            ],
            [
                'id' => 5,
                'name' => 'Premium Spice Collection',
                'category' => 'Spices',
                'price' => 799,
                'original_price' => 999,
                'image' => '/images/spice-collection.jpg',
                'rating' => 4.5,
                'reviews' => 67,
                'tag' => 'Premium',
                'tag_color' => 'bg-blue-500',
                'in_stock' => false,
                'description' => 'Collection of 6 premium spices'
            ],
            [
                'id' => 6,
                'name' => 'Protein Rich Trail Mix',
                'category' => 'Healthy Snacks',
                'price' => 449,
                'original_price' => 549,
                'image' => '/images/trail-mix.jpg',
                'rating' => 4.6,
                'reviews' => 134,
                'tag' => 'Premium',
                'tag_color' => 'bg-blue-500',
                'in_stock' => true,
                'description' => 'High protein trail mix for energy'
            ],
        ];
    }

    public function updatedSearch()
    {
        // Reset pagination when search changes
        $this->resetPage();
    }

    public function updatedSelectedCategory()
    {
        // Reset pagination when category changes
        $this->resetPage();
    }

    public function setCategory($category)
    {
        $this->selectedCategory = $category;
        $this->resetPage();
    }

    public function addToCart($productId)
    {
        // Find the product
        $product = collect($this->products)->firstWhere('id', $productId);
        
        if ($product && $product['in_stock']) {
            // In a real app, you would add to cart in database/session
            session()->flash('success', $product['name'] . ' added to cart!');
            
            // Emit event to update cart count
            $this->dispatch('cartUpdated', session('cart_count', 0) + 1);
            session()->put('cart_count', session('cart_count', 0) + 1);
        }
    }

    public function getFilteredProducts()
    {
        $filtered = collect($this->products);

        // Filter by search
        if ($this->search) {
            $filtered = $filtered->filter(function ($product) {
                return str_contains(strtolower($product['name']), strtolower($this->search)) ||
                       str_contains(strtolower($product['category']), strtolower($this->search)) ||
                       str_contains(strtolower($product['description']), strtolower($this->search));
            });
        }

        // Filter by category
        if ($this->selectedCategory !== 'All') {
            $filtered = $filtered->filter(function ($product) {
                return $product['category'] === $this->selectedCategory;
            });
        }

        // Sort
        switch ($this->sortBy) {
            case 'price_low':
                $filtered = $filtered->sortBy('price');
                break;
            case 'price_high':
                $filtered = $filtered->sortByDesc('price');
                break;
            case 'rating':
                $filtered = $filtered->sortByDesc('rating');
                break;
            default:
                $filtered = $filtered->sortBy('name');
                break;
        }

        return $filtered->values()->all();
    }

    public function render()
    {
        $filteredProducts = $this->getFilteredProducts();
        
        return view('livewire.public.shop', [
            'filteredProducts' => $filteredProducts,
            'totalProducts' => count($filteredProducts)
        ]);
    }
}
