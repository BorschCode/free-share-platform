<?php

namespace App\Livewire\Items;

use App\Models\Item;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public string $category = '';

    public string $city = '';

    public string $status = '';

    public string $sort = 'newest';

    protected $queryString = [
        'search' => ['except' => ''],
        'category' => ['except' => ''],
        'city' => ['except' => ''],
        'status' => ['except' => ''],
        'sort' => ['except' => 'newest'],
    ];

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

    public function render()
    {
        $query = Item::query()
            ->with(['user', 'votes', 'comments'])
            ->when($this->search, function ($q) {
                $q->where(function ($query) {
                    $query->where('title', 'like', "%{$this->search}%")
                        ->orWhere('description', 'like', "%{$this->search}%");
                });
            })
            ->when($this->category, fn ($q) => $q->where('category', $this->category))
            ->when($this->city, fn ($q) => $q->where('city', $this->city))
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
            'categories' => Item::query()->distinct()->pluck('category')->filter()->sort()->values(),
            'cities' => Item::query()->distinct()->pluck('city')->filter()->sort()->values(),
        ]);
    }
}
