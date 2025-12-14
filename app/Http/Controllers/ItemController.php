<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Models\Item;
use App\Models\Tag;

class ItemController extends Controller
{
    /**
     * List all items.
     */
    public function index()
    {
        $items = Item::latest()->paginate(15);

        return view('items.index', compact('items'));
    }

    /**
     * Show the form for creating a new item.
     */
    public function create()
    {
        $tags = Tag::all();

        return view('items.create', compact('tags'));
    }

    /**
     * Store a newly created item.
     */
    public function store(StoreItemRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        // Handle multiple photo upload
        if ($request->hasFile('photos')) {
            $data['photos'] = [];
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('items', 'public');
                $data['photos'][] = $path;
            }
        }

        $item = Item::create($data);

        // Sync tags
        if ($request->has('tags')) {
            $item->tags()->sync($request->input('tags'));
        }

        return redirect()
            ->route('items.show', $item)
            ->with('success', 'Item created successfully.');
    }

    /**
     * Display a single item.
     */
    public function show(Item $item)
    {
        return view('items.show', compact('item'));
    }

    /**
     * Show the form for editing an item.
     */
    public function edit(Item $item)
    {
        $this->authorize('update', $item);

        $tags = Tag::all();

        return view('items.edit', compact('item', 'tags'));
    }

    /**
     * Update the specified item.
     */
    public function update(UpdateItemRequest $request, Item $item)
    {
        $this->authorize('update', $item);

        $data = $request->validated();

        // Handle new photos
        if ($request->hasFile('photos')) {
            $data['photos'] = [];
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('items', 'public');
                $data['photos'][] = $path;
            }
        }

        $item->update($data);

        // Sync tags
        if ($request->has('tags')) {
            $item->tags()->sync($request->input('tags'));
        } else {
            $item->tags()->detach();
        }

        return redirect()
            ->route('items.show', $item)
            ->with('success', 'Item updated successfully.');
    }

    /**
     * Delete an item.
     */
    public function destroy(Item $item)
    {
        $this->authorize('delete', $item);

        $item->delete();

        return redirect()
            ->route('items.index')
            ->with('success', 'Item deleted.');
    }
}
