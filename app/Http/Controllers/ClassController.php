<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index()
    {
        $classes = Classes::withCount('users')->latest()->paginate(15);
        return view('class.index', compact('classes'));
    }

    public function create()
    {
        return view('class.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:classes',
            'description' => 'nullable|string',
        ]);

        Classes::create($validated);

        return redirect()->route('classes.index')
            ->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function edit(Classes $class)
    {
        return view('class.edit', compact('class'));
    }

    public function update(Request $request, Classes $class)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:classes,code,' . $class->id,
            'description' => 'nullable|string',
        ]);

        $class->update($validated);

        return redirect()->route('classes.index')
            ->with('success', 'Kelas berhasil diperbarui.');
    }

    public function destroy(Classes $class)
    {
        $class->delete();
        return redirect()->route('classes.index')
            ->with('success', 'Kelas berhasil dihapus.');
    }
}
