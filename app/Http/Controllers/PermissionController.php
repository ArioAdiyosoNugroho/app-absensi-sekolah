<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PermissionController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin() || $user->isGuru()) {
            $permissions = Permission::with(['user', 'approver'])
                ->latest()
                ->paginate(15);
        } else {
            $permissions = Permission::with('approver')
                ->where('user_id', $user->id)
                ->latest()
                ->paginate(15);
        }

        return view('permission.index', compact('permissions'));
    }

    public function create()
    {
        return view('permission.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:izin,sakit',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|min:10',
            'proof_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'user_id' => Auth::id(),
            'type' => $validated['type'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'reason' => $validated['reason'],
        ];

        if ($request->hasFile('proof_image')) {
            $data['proof_image'] = $request->file('proof_image')
                ->store('permissions', 'public');
        }

        Permission::create($data);

        return redirect()->route('permissions.index')
            ->with('success', 'Pengajuan ' . $validated['type'] . ' berhasil dikirim.');
    }

    public function show(Permission $permission)
    {
        $this->authorizeView($permission);
        return view('permission.show', compact('permission'));
    }

    public function approve(Request $request, Permission $permission)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
        ]);

        $permission->update([
            'status' => $request->status,
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        $message = $request->status === 'disetujui'
            ? 'Pengajuan ' . $permission->type . ' disetujui.'
            : 'Pengajuan ' . $permission->type . ' ditolak.';

        if ($request->status === 'disetujui') {
            $dates = [];
            $current = \Carbon\Carbon::parse($permission->start_date);
            $end = \Carbon\Carbon::parse($permission->end_date);

            while ($current->lte($end)) {
                $dates[] = $current->format('Y-m-d');
                $current->addDay();
            }

            foreach ($dates as $date) {
                \App\Models\Attendance::updateOrCreate(
                    [
                        'user_id' => $permission->user_id,
                        'date' => $date,
                    ],
                    [
                        'status' => $permission->type === 'sakit' ? 'sakit' : 'izin',
                    ]
                );
            }
        }

        return redirect()->route('permissions.index')
            ->with('success', $message);
    }

    private function authorizeView(Permission $permission)
    {
        $user = Auth::user();
        if ($user->isAdmin() || $user->isGuru() || $permission->user_id === $user->id) {
            return;
        }
        abort(403);
    }
}
