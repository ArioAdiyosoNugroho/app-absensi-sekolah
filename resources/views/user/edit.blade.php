@extends('layouts.app')
@section('title', 'Edit Pengguna')

@section('content')
<div class="p-4 md:p-6 max-w-2xl mx-auto">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Edit Pengguna</h1>
        <p class="text-gray-500 text-sm mt-1">{{ $user->name }}</p>
    </div>

    <div class="mt-6 bg-white rounded-xl border border-gray-200 p-6">
        <form method="POST" action="{{ route('users.update', $user) }}">
            @csrf @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                    <select name="role" required
                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                        <option value="murid" {{ $user->role == 'murid' ? 'selected' : '' }}>Murid</option>
                        <option value="guru" {{ $user->role == 'guru' ? 'selected' : '' }}>Guru</option>
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">NIS</label>
                        <input type="text" name="nis" value="{{ old('nis', $user->nis) }}"
                            class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">NIP</label>
                        <input type="text" name="nip" value="{{ old('nip', $user->nip) }}"
                            class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">No. Telepon</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru (kosongkan jika tidak diubah)</label>
                    <input type="password" name="password"
                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                </div>
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" value="1" {{ $user->is_active ? 'checked' : '' }}
                        class="rounded border-gray-300 text-indigo-600">
                    <span class="text-sm text-gray-700">Aktif</span>
                </label>
                <button type="submit" class="w-full py-2.5 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg text-sm transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
