<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Material;

class MaterialController extends Controller
{
    // Read-only material catalog for employees — no pricing data is
    // queried or exposed here; unit_cost/selling_price stay super_admin-only.
    public function index()
    {
        $materials = Material::where('is_archived', false)
            ->orderBy('name')
            ->get();

        $total = $materials->count();
        $byCategory = $materials->groupBy('category')->map->count();

        return view('employee.materials', compact('materials', 'total', 'byCategory'));
    }
}
