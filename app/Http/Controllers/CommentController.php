<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Item;

class CommentController extends Controller
{
    public function store(CommentRequest $request, Item $item)
    {
        Comment::create([
            'item_id' => $item->id,
            'user_id' => auth()->id(),
            'content' => $request->validated('content'),
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
