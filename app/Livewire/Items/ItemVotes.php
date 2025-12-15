<?php

namespace App\Livewire\Items;

use App\Models\Item;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ItemVotes extends Component
{
    public Item $item;

    public $userVote;

    public function mount(): void
    {
        $this->userVote = $this->item->votes()->where('user_id', auth()->id())->first();
    }

    public function vote($type): void
    {
        if (! $this->userVote) {
            $this->item->votes()->create([
                'user_id' => auth()->id(),
                'vote' => $type,
            ]);
        } elseif ($this->userVote->vote == $type) {
            $this->userVote->delete();
        } else {
            $this->userVote->update(['vote' => $type]);
        }

        $this->item->load('votes');
        $this->userVote = $this->item->votes()->where('user_id', auth()->id())->first();
    }

    public function render(): Factory|View|\Illuminate\View\View
    {
        return view('livewire.items.item-votes', [
            'upvotes' => $this->item->votes()->where('vote', 1)->count(),
            'downvotes' => $this->item->votes()->where('vote', -1)->count(),
        ]);
    }
}
