<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class UserController extends Controller
{
    public function index()
    {
        $items = Item::with('category')->get();
        return view('user.catalog', compact('items'));
    }
}
