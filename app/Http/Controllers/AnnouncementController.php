<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::with('creator')
            ->latest()
            ->paginate(15);

        return view('announcement.index', compact('announcements'));
    }

    public function create()
    {
        return view('announcement.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'target_role' => 'required|in:all,guru,murid',
        ]);

        Announcement::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'target_role' => $validated['target_role'],
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('announcements.index')
            ->with('success', 'Pengumuman berhasil dibuat.');
    }

    public function show(Announcement $announcement)
    {
        return view('announcement.show', compact('announcement'));
    }

    public function edit(Announcement $announcement)
    {
        return view('announcement.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'target_role' => 'required|in:all,guru,murid',
            'is_active' => 'boolean',
        ]);

        $announcement->update($validated);

        return redirect()->route('announcements.index')
            ->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        return redirect()->route('announcements.index')
            ->with('success', 'Pengumuman berhasil dihapus.');
    }
}
