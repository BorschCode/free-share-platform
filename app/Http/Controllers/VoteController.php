<?php

namespace App\Http\Controllers;

use App\Http\Requests\VoteRequest;
use App\Models\Item;
use App\Models\Vote;

class VoteController extends Controller
{
    public function store(VoteRequest $request, Item $item)
    {
        Vote::create([
            'item_id' => $item->id,
            'user_id' => auth()->id(),
            'vote' => $request->validated('vote'),
        ]);

        return back()->with('success', 'Vote added.');
    }

    public function destroy(Item $item)
    {
        $vote = $item->votes()->where('user_id', auth()->id())->firstOrFail();

        $this->authorize('delete', $vote);

        $vote->delete();

        return back()->with('success', 'Vote removed.');
    }
}
