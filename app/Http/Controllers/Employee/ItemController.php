<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Item;

class ItemController extends Controller
{
    // Read-only item catalog for employees — no pricing data is
    // queried or exposed here; unit_cost/selling_price stay super_admin-only.
    public function index()
    {
        $items = Item::where('is_archived', false)
            ->orderBy('name')
            ->get();

        $total = $items->count();
        $byCategory = $items->groupBy('category')->map->count();

        return view('employee.items', compact('items', 'total', 'byCategory'));
    }
}
