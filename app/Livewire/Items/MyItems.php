<?php

namespace App\Livewire\Items;

use App\Enums\ItemStatus;
use App\Models\Item;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View as ViewContracts;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class MyItems extends Component
{
    use WithPagination;

    public string $search = '';

    public string $status = '';

    public string $sort = 'newest';

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
        'sort' => ['except' => 'newest'],
    ];

    public function updatedSearch(): void
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
        $this->status = '';
        $this->sort = 'newest';
        $this->resetPage();
    }

    public function updateStatus(Item $item, int $newStatus): void
    {
        // Ensure the user owns this item
        if ($item->user_id !== auth()->id()) {
            $this->dispatch('error', message: 'You are not authorized to update this item.');

            return;
        }

        $item->update(['status' => $newStatus]);

        $this->dispatch('success', message: 'Item status updated successfully.');
    }

    public function deleteItem(Item $item): void
    {
        // Ensure the user owns this item
        if ($item->user_id !== auth()->id()) {
            $this->dispatch('error', message: 'You are not authorized to delete this item.');

            return;
        }

        $item->delete();

        $this->dispatch('success', message: 'Item deleted successfully.');
    }

    public function render(): Factory|ViewContracts|View
    {
        $query = Item::query()
            ->where('user_id', auth()->id())
            ->with(['votes', 'comments'])
            ->when($this->search, function ($q) {
                $q->where(function ($query) {
                    $query->where('title', 'like', "%{$this->search}%")
                        ->orWhere('description', 'like', "%{$this->search}%");
                });
            })
            ->when($this->status, fn ($q) => $q->where('status', (int) $this->status));

        if ($this->sort === 'newest') {
            $query->latest();
        } elseif ($this->sort === 'oldest') {
            $query->oldest();
        } elseif ($this->sort === 'upvotes') {
            $query->withCount([
                'votes as upvotes_count' => fn ($q) => $q->where('vote', 1),
            ])->orderByDesc('upvotes_count');
        }

        return view('livewire.items.my-items', [
            'items' => $query->paginate(12),
            'statuses' => ItemStatus::cases(),
        ])->layout('components.layouts.bootstrap');
    }
}
