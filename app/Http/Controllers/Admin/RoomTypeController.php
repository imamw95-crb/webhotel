<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RoomType;
use Illuminate\Http\Request;

class RoomTypeController extends Controller
{
    public function index()
    {
        $roomTypes = RoomType::ordered()->paginate(20);

        return view('admin.room-types.index', compact('roomTypes'));
    }

    public function create()
    {
        return view('admin.room-types.form', ['roomType' => null]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:room_types,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'base_price' => 'required|numeric|min:0',
            'max_occupancy' => 'integer|min:1|max:20',
            'max_adults' => 'integer|min:1|max:10',
            'max_children' => 'integer|min:0|max:10',
            'room_size' => 'nullable|string|max:50',
            'bed_configuration' => 'nullable|string|max:255',
            'image_path' => 'nullable|string|max:500',
            'facilities' => 'nullable|array',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);
        RoomType::create($validated);

        return redirect()->route('admin.room-types.index')->with('success', 'Room type created successfully.');
    }

    public function edit(RoomType $roomType)
    {
        return view('admin.room-types.form', compact('roomType'));
    }

    public function update(Request $request, RoomType $roomType)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:room_types,code,'.$roomType->id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'base_price' => 'required|numeric|min:0',
            'max_occupancy' => 'integer|min:1|max:20',
            'max_adults' => 'integer|min:1|max:10',
            'max_children' => 'integer|min:0|max:10',
            'room_size' => 'nullable|string|max:50',
            'bed_configuration' => 'nullable|string|max:255',
            'image_path' => 'nullable|string|max:500',
            'facilities' => 'nullable|array',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', false);
        $roomType->update($validated);

        return redirect()->route('admin.room-types.index')->with('success', 'Room type updated successfully.');
    }

    public function destroy(RoomType $roomType)
    {
        $roomType->delete();

        return redirect()->route('admin.room-types.index')->with('success', 'Room type deleted successfully.');
    }
}
