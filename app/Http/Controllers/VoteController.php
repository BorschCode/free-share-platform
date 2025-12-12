<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Vote;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function store(Request $request, Item $item)
    {
        // Policy handles all checks (duplicate votes, owner voting, etc.)
        $this->authorize('create', [Vote::class, $item]);

        Vote::create([
            'item_id' => $item->id,
            'user_id' => auth()->id(),
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
