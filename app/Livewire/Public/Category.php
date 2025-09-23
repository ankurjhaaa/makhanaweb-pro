<?php

namespace App\Livewire\Public;

use App\Models\Category as CategoryModel;
use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class Category extends Component
{
    use WithPagination;

    public $slug;
    public $category;
    public $search = '';
    public $breadcrumbs = [];

    public function mount($slug)
    {
        $this->slug = $slug;
        $this->category = CategoryModel::where('slug', $slug)->firstOrFail();

        $this->buildBreadcrumbs($this->category);
    }

    protected function buildBreadcrumbs($category)
    {
        $breadcrumbs = [];
        while ($category) {
            $breadcrumbs[] = [
                'label' => $category->name,
                'url' => route('category', $category->slug),
            ];
            $category = $category->parent;
        }

        $this->breadcrumbs = array_reverse($breadcrumbs);

        array_unshift($this->breadcrumbs, [
            'label' => 'Home',
            'url' => route('home'),
        ]);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        // sab children + current category ke IDs lelo
        $categoryIds = $this->category->getAllChildrenIds();

        $query = Product::whereIn('category_id', $categoryIds);

        if (!empty($this->search)) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        $products = $query->paginate(12);

        return view('livewire.public.category', [
            'category' => $this->category,
            'products' => $products,
            'breadcrumbs' => $this->breadcrumbs,
        ]);
    }

}
