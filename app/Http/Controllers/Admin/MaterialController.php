<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    private const CATEGORIES = ['CCTV', 'Solar', 'PA System', 'General'];

    public function index()
    {
        $materials = Material::where('is_archived', false)
            ->orderBy('name')
            ->get();

        $total = $materials->count();
        $byCategory = $materials->groupBy('category')->map->count();
        $canManage = Auth::user()->isSuperAdmin();

        return view('admin.materials.materials', compact('materials', 'total', 'byCategory', 'canManage'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateMaterial($request);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('materials', 'public');
        }

        $material = Material::create($validated);

        ActivityLogController::log(
            'Material',
            'Created',
            "New material added: {$material->name}.",
            Auth::id(),
            Auth::user()->full_name
        );

        return response()->json([
            'success' => true,
            'message' => "{$material->name} added successfully.",
        ]);
    }

    public function update(Request $request, Material $material)
    {
        $validated = $this->validateMaterial($request);

        if ($request->hasFile('image')) {
            if ($material->image_path) {
                Storage::disk('public')->delete($material->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('materials', 'public');
        }

        $material->update($validated);

        ActivityLogController::log(
            'Material',
            'Updated',
            "Material updated: {$material->name}.",
            Auth::id(),
            Auth::user()->full_name
        );

        return response()->json([
            'success' => true,
            'message' => "{$material->name} updated successfully.",
        ]);
    }

    public function archive(Material $material)
    {
        $material->update([
            'is_archived' => true,
            'archived_at' => now(),
        ]);

        ActivityLogController::log(
            'Material',
            'Archived',
            "Material archived: {$material->name}.",
            Auth::id(),
            Auth::user()->full_name
        );

        return response()->json([
            'success' => true,
            'message' => "{$material->name} moved to archive.",
        ]);
    }

    public function unarchive(Material $material)
    {
        $material->update([
            'is_archived' => false,
            'archived_at' => null,
        ]);

        ActivityLogController::log(
            'Material',
            'Restored',
            "Material restored from archive: {$material->name}.",
            Auth::id(),
            Auth::user()->full_name
        );

        return response()->json([
            'success' => true,
            'message' => "{$material->name} restored.",
        ]);
    }

    public function archivedPage()
    {
        $materials = Material::where('is_archived', true)
            ->orderByDesc('archived_at')
            ->get();

        $total = $materials->count();
        $byCategory = $materials->groupBy('category')->map->count();

        return view('admin.materials.archive-materials', compact('materials', 'total', 'byCategory'));
    }

    private function validateMaterial(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:150',
            'category' => ['required', 'in:'.implode(',', self::CATEGORIES)],
            'unit' => 'required|string|max:30',
            'unit_cost' => 'required|numeric|min:0',
            'selling_price' => 'nullable|numeric|min:0',
            'supplier' => 'nullable|string|max:150',
            'location' => 'nullable|string|max:150',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|max:2048',
        ]);
    }
}