<?php

namespace App\Http\Controllers;

use App\Models\Item;

class IndexController extends Controller
{
    public function __invoke()
    {
        $items = Item::query()
            ->with(['user', 'votes', 'comments', 'category', 'city', 'tags'])
            ->available()
            ->latest()
            ->limit(10)
            ->get();

        return view('welcome', ['items' => $items]);
    }
}
