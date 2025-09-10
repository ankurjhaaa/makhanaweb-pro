<?php

namespace App\Livewire\Public;

use App\Models\Category;
use App\Models\Product;
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
    public $categories = [];
    public $totalProducts;

    public function mount()
    {
        // Category list
        $this->categories = Category::pluck('name')->toArray();
        $this->totalProducts = Product::count();
    }

    public function setCategory($category)
    {
        $this->selectedCategory = $category;
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedSortBy()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Product::query()->with('category');


        if ($this->selectedCategory !== 'All') {
            $query->whereHas('category', function ($q) {
                $q->where('name', $this->selectedCategory);
            });
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }


        switch ($this->sortBy) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'rating':
                $query->orderBy('rating', 'desc');
                break;
            default:
                $query->orderBy('name', 'asc');
                break;
        }

        $filteredProducts = $query->paginate(12);

        return view('livewire.public.shop', [
            'filteredProducts' => $filteredProducts,
            'totalProducts' => $this->totalProducts,
            'categories' => $this->categories,
            'selectedCategory' => $this->selectedCategory,
        ]);
    }
}
