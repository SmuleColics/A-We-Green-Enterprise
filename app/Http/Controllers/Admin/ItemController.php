<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    private const CATEGORIES = ['CCTV', 'Solar', 'PA System', 'General', 'Labor'];

    public function index()
    {
        $items = Item::where('is_archived', false)
            ->orderBy('name')
            ->get();

        $total = $items->count();
        $byCategory = $items->groupBy('category')->map->count();
        $canManage = Auth::user()->isSuperAdmin();

        return view('admin.items.items', compact('items', 'total', 'byCategory', 'canManage'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateItem($request);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('items', 'public');
        }

        $item = Item::create($validated);

        ActivityLogController::log(
            'Item',
            'Created',
            "New item added: {$item->name}.",
            Auth::id(),
            Auth::user()->full_name
        );

        return response()->json([
            'success' => true,
            'message' => "{$item->name} added successfully.",
        ]);
    }

    public function update(Request $request, Item $item)
    {
        $validated = $this->validateItem($request);

        if ($request->hasFile('image')) {
            if ($item->image_path) {
                Storage::disk('public')->delete($item->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('items', 'public');
        }

        $item->update($validated);

        ActivityLogController::log(
            'Item',
            'Updated',
            "Item updated: {$item->name}.",
            Auth::id(),
            Auth::user()->full_name
        );

        return response()->json([
            'success' => true,
            'message' => "{$item->name} updated successfully.",
        ]);
    }

    public function archive(Item $item)
    {
        $item->update([
            'is_archived' => true,
            'archived_at' => now(),
        ]);

        ActivityLogController::log(
            'Item',
            'Archived',
            "Item archived: {$item->name}.",
            Auth::id(),
            Auth::user()->full_name
        );

        return response()->json([
            'success' => true,
            'message' => "{$item->name} moved to archive.",
        ]);
    }

    public function unarchive(Item $item)
    {
        $item->update([
            'is_archived' => false,
            'archived_at' => null,
        ]);

        ActivityLogController::log(
            'Item',
            'Restored',
            "Item restored from archive: {$item->name}.",
            Auth::id(),
            Auth::user()->full_name
        );

        return response()->json([
            'success' => true,
            'message' => "{$item->name} restored.",
        ]);
    }

    public function archivedPage()
    {
        $items = Item::where('is_archived', true)
            ->orderByDesc('archived_at')
            ->get();

        $total = $items->count();
        $byCategory = $items->groupBy('category')->map->count();

        return view('admin.items.archive-items', compact('items', 'total', 'byCategory'));
    }

    private function validateItem(Request $request): array
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'category' => ['required', 'in:'.implode(',', self::CATEGORIES)],
            'unit' => 'required|string|max:30',
            'unit_cost' => 'nullable|numeric|min:0',
            'selling_price' => 'nullable|numeric|min:0',
            'supplier' => 'nullable|string|max:150',
            'location' => 'nullable|string|max:150',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|max:2048',
        ]);

        // Labor is a flat-priced service charge, not a physical good — cost
        // basis, supplier, storage location, and photo don't apply to it.
        if ($validated['category'] === 'Labor') {
            $validated['unit_cost'] = null;
            $validated['supplier'] = null;
            $validated['location'] = null;
            $validated['description'] = null;
        } else {
            $request->validate(['unit_cost' => 'required|numeric|min:0']);
        }

        return $validated;
    }
}
