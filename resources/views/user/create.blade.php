@extends('layouts.app')
@section('title', 'Tambah Pengguna')

@section('content')
<div class="p-4 md:p-6 max-w-2xl mx-auto">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Tambah Pengguna</h1>
        <p class="text-gray-500 text-sm mt-1">Buat akun baru untuk guru atau murid</p>
    </div>

    <div class="mt-6 bg-white rounded-xl border border-gray-200 p-6">
        <form method="POST" action="{{ route('users.store') }}">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                    @error('name')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                    @error('email')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                    <select name="role" required
                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                        <option value="murid" {{ old('role') == 'murid' ? 'selected' : '' }}>Murid</option>
                        <option value="guru" {{ old('role') == 'guru' ? 'selected' : '' }}>Guru</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">NIS (Murid)</label>
                        <input type="text" name="nis" value="{{ old('nis') }}"
                            class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">NIP (Guru)</label>
                        <input type="text" name="nip" value="{{ old('nip') }}"
                            class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">No. Telepon</label>
                    <input type="text" name="phone" value="{{ old('phone') }}"
                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" required
                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                </div>
                <button type="submit" class="w-full py-2.5 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg text-sm transition-colors">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
