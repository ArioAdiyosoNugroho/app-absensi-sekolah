@extends('layouts.app')
@section('title', 'Izin / Sakit')

@section('content')
<div class="p-4 md:p-6 space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Izin / Sakit</h1>
            <p class="text-gray-500 text-sm mt-1">Daftar pengajuan izin dan sakit</p>
        </div>
        <a href="{{ route('permissions.create') }}" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors">
            + Ajukan Baru
        </a>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-left text-gray-500">
                        <th class="p-4 font-medium">Nama</th>
                        <th class="p-4 font-medium">Tipe</th>
                        <th class="p-4 font-medium">Tanggal</th>
                        <th class="p-4 font-medium">Alasan</th>
                        <th class="p-4 font-medium">Status</th>
                        <th class="p-4 font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($permissions as $permission)
                    <tr class="border-t border-gray-100 hover:bg-gray-50">
                        <td class="p-4 font-medium text-gray-900">{{ $permission->user->name }}</td>
                        <td class="p-4">
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $permission->type == 'sakit' ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700' }}">
                                {{ ucfirst($permission->type) }}
                            </span>
                        </td>
                        <td class="p-4">
                            {{ $permission->start_date->format('d/m/Y') }} - {{ $permission->end_date->format('d/m/Y') }}
                        </td>
                        <td class="p-4 max-w-xs truncate">{{ $permission->reason }}</td>
                        <td class="p-4">
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium
                                @if($permission->status == 'disetujui') bg-green-100 text-green-700
                                @elseif($permission->status == 'ditolak') bg-red-100 text-red-700
                                @else bg-yellow-100 text-yellow-700 @endif">
                                {{ ucfirst($permission->status) }}
                            </span>
                        </td>
                        <td class="p-4">
                            <a href="{{ route('permissions.show', $permission) }}" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-gray-500">Belum ada pengajuan izin/sakit</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($permissions->hasPages())
        <div class="p-4 border-t border-gray-200">
            {{ $permissions->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
