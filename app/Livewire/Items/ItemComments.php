<?php

namespace App\Livewire\Items;

use App\Models\Comment;
use App\Models\Item;
use Livewire\Component;

class ItemComments extends Component
{
    public Item $item;

    public $content = '';

    protected $rules = [
        'content' => 'required|string|max:1000',
    ];

    public function addComment(): void
    {
        $this->validate();

        Comment::create([
            'item_id' => $this->item->id,
            'user_id' => auth()->id(),
            'content' => $this->content,
        ]);

        $this->content = '';
        $this->item->load('comments.user');
    }

    public function deleteComment(Comment $comment): void
    {
        $this->authorize('delete', $comment);
        $comment->delete();
        $this->item->load('comments.user');
    }

    public function render()
    {
        return view('livewire.items.item-comments', [
            'comments' => $this->item->comments()->with('user')->latest()->get(),
        ])->layout('components.layouts.bootstrap');
    }
}
