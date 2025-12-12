<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemRequest;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function store(StoreItemRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        // Handle photos
        if ($request->hasFile('photos')) {
            $data['photos'] = [];
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('items', 'public');
                $data['photos'][] = $path;
            }
        }

        $item = Item::create($data);
        return redirect()->route('items.show', $item);
    }

    public function update(UpdateItemRequest $request, Item $item)
    {
        $this->authorize('update', $item); // Ensure user owns the item

        $data = $request->validated();

        // Handle photos if uploaded
        if ($request->hasFile('photos')) {
            $data['photos'] = [];
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('items', 'public');
                $data['photos'][] = $path;
            }
        }

        $item->update($data);
        return redirect()->route('items.show', $item);
    }


    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        //
    }
}
