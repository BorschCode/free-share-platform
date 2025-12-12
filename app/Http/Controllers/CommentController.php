<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Item;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Item $item)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:500',
        ]);

        Comment::create([
            'item_id' => $item->id,
            'user_id' => auth()->id(),
            'content' => $validated['content'],
        ]);

        return back()->with('success', 'Comment added.');
    }

    public function destroy(Item $item, Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return back()->with('success', 'Comment deleted.');
    }
}
