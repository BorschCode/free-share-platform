<?php

namespace App\Livewire\Items;

use App\Models\Category;
use App\Models\City;
use App\Models\Item;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View as ViewContracts;
use Illuminate\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[Url(except: '')]
    public mixed $search = '';

    #[Url(except: '')]
    public mixed $category = '';

    #[Url(except: '')]
    public mixed $city = '';

    #[Url(except: '')]
    public mixed $status = '';

    #[Url(except: 'newest')]
    public mixed $sort = 'newest';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedCategory(): void
    {
        $this->resetPage();
    }

    public function updatedCity(): void
    {
        $this->resetPage();
    }

    public function updatedStatus(): void
    {
        $this->resetPage();
    }

    public function updatedSort(): void
    {
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->search = '';
        $this->category = '';
        $this->city = '';
        $this->status = '';
        $this->sort = 'newest';
        $this->resetPage();
    }

    public function render(): Factory|ViewContracts|View
    {
        $query = Item::query()
            ->with(['user', 'votes', 'comments', 'category', 'city', 'tags'])
            ->when($this->search, function ($q) {
                $q->where(function ($query) {
                    $query->where('title', 'like', "%{$this->search}%")
                        ->orWhere('description', 'like', "%{$this->search}%");
                });
            })
            ->when($this->category, fn ($q) => $q->where('category_id', $this->category))
            ->when($this->city, fn ($q) => $q->where('city_id', $this->city))
            ->when($this->status, fn ($q) => $q->where('status', (int) $this->status));

        if ($this->sort === 'newest') {
            $query->latest();
        } elseif ($this->sort === 'upvotes') {
            $query->withCount([
                'votes as upvotes_count' => fn ($q) => $q->where('vote', 1),
            ])->orderByDesc('upvotes_count');
        }

        return view('livewire.items.index', [
            'items' => $query->paginate(12),
            'categoryOptions' => Category::query()
                ->select('id', 'name')
                ->orderBy('name')
                ->get(),

            'cityOptions' => City::query()
                ->select('id', 'name')
                ->orderBy('name')
                ->get(),

        ])->layout('components.layouts.bootstrap');
    }
}
