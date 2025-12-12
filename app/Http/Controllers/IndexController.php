<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Models\Item;

class IndexController extends Controller
{
    public function __invoke()
    {
        $items = Item::query()
            ->with(['user', 'votes', 'comments'])
            ->available()
            ->latest()
            ->limit(10)
            ->get();

        return view('welcome', ['items' => $items]);
    }
}
