<?php

namespace App\Http\Controllers;

use App\Models\SchoolLocation;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        $locations = SchoolLocation::latest()->get();
        return view('location.index', compact('locations'));
    }

    public function create()
    {
        return view('location.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'radius' => 'required|integer|min:10|max:1000',
        ]);

        SchoolLocation::create($validated);

        return redirect()->route('locations.index')
            ->with('success', 'Lokasi sekolah berhasil ditambahkan.');
    }

    public function edit(SchoolLocation $location)
    {
        return view('location.edit', compact('location'));
    }

    public function update(Request $request, SchoolLocation $location)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'radius' => 'required|integer|min:10|max:1000',
            'is_active' => 'boolean',
        ]);

        $location->update($validated);

        return redirect()->route('locations.index')
            ->with('success', 'Lokasi sekolah berhasil diperbarui.');
    }

    public function destroy(SchoolLocation $location)
    {
        $location->delete();
        return redirect()->route('locations.index')
            ->with('success', 'Lokasi sekolah berhasil dihapus.');
    }
}
