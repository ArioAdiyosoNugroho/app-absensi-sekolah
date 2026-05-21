@extends('layouts.app')
@section('title', 'Kelola Pengguna')

@section('content')
<div class="p-4 md:p-6 space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Kelola Pengguna</h1>
            <p class="text-gray-500 text-sm mt-1">Daftar semua pengguna sistem</p>
        </div>
        <a href="{{ route('users.create') }}" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors">
            + Tambah Pengguna
        </a>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-left text-gray-500">
                        <th class="p-4 font-medium">Nama</th>
                        <th class="p-4 font-medium">Email</th>
                        <th class="p-4 font-medium">Role</th>
                        <th class="p-4 font-medium">NIS/NIP</th>
                        <th class="p-4 font-medium">Status</th>
                        <th class="p-4 font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr class="border-t border-gray-100 hover:bg-gray-50">
                        <td class="p-4 font-medium text-gray-900">{{ $user->name }}</td>
                        <td class="p-4 text-gray-500">{{ $user->email }}</td>
                        <td class="p-4">
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium
                                @if($user->role == 'admin') bg-purple-100 text-purple-700
                                @elseif($user->role == 'guru') bg-blue-100 text-blue-700
                                @else bg-green-100 text-green-700 @endif">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="p-4">{{ $user->nis ?? $user->nip ?? '-' }}</td>
                        <td class="p-4">
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $user->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="p-4">
                            <a href="{{ route('users.edit', $user) }}" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">
                                Edit
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
        <div class="p-4 border-t border-gray-200">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
