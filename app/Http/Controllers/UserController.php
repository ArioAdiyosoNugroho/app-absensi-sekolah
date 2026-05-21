<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Classes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(15);
        return view('user.index', compact('users'));
    }

    public function create()
    {
        $classes = Classes::all();
        return view('user.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role' => 'required|in:admin,guru,murid',
            'nis' => 'nullable|unique:users',
            'nip' => 'nullable|unique:users',
            'phone' => 'nullable|string|max:20',
            'class_id' => 'nullable|exists:classes,id',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'nis' => $validated['nis'] ?? null,
            'nip' => $validated['nip'] ?? null,
            'phone' => $validated['phone'] ?? null,
        ]);

        if ($request->filled('class_id')) {
            $user->classes()->attach($request->class_id);
        }

        return redirect()->route('users.index')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        $classes = Classes::all();
        return view('user.edit', compact('user', 'classes'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8',
            'role' => 'required|in:admin,guru,murid',
            'nis' => 'nullable|unique:users,nis,' . $user->id,
            'nip' => 'nullable|unique:users,nip,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'is_active' => 'boolean',
            'class_id' => 'nullable|exists:classes,id',
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'nis' => $validated['nis'] ?? null,
            'nip' => $validated['nip'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'is_active' => $request->boolean('is_active'),
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        if ($request->filled('class_id')) {
            $user->classes()->sync([$request->class_id]);
        } else {
            $user->classes()->detach();
        }

        return redirect()->route('users.index')
            ->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->isAdmin() && User::where('role', 'admin')->count() <= 1) {
            return redirect()->route('users.index')
                ->with('error', 'Tidak dapat menghapus admin terakhir.');
        }

        $user->delete();
        return redirect()->route('users.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }
}
