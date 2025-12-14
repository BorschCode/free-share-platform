<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class VoteController extends Controller
{
    public function store(Request $request, Item $item)
    {
        $validated = $request->validate([
            'vote' => 'required|integer|in:-1,1',
        ]);

        // Check authorization using policy
        $response = Gate::inspect('create', [Vote::class, $item]);

        if ($response->denied()) {
            return back()->with('error', $response->message());
        }

        Vote::create([
            'item_id' => $item->id,
            'user_id' => auth()->id(),
            'vote' => $validated['vote'],
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
