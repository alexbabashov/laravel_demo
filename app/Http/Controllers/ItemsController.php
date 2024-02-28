<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemsController extends Controller
{
    public function index()
    {

        $items = Item::all();

        return view('items',['items' => $items,
                        ]);
    }
}
