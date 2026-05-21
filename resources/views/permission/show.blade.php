@extends('layouts.app')
@section('title', 'Detail Pengajuan')

@section('content')
<div class="p-4 md:p-6 max-w-2xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Detail Pengajuan</h1>
            <p class="text-gray-500 text-sm mt-1">Detail pengajuan izin/sakit</p>
        </div>
        <a href="{{ route('permissions.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">Kembali</a>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-6 space-y-4">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-xs text-gray-500">Nama</p>
                <p class="font-medium text-gray-900">{{ $permission->user->name }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500">Tipe</p>
                <p class="font-medium">
                    <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $permission->type == 'sakit' ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700' }}">
                        {{ ucfirst($permission->type) }}
                    </span>
                </p>
            </div>
            <div>
                <p class="text-xs text-gray-500">Tanggal Mulai</p>
                <p class="font-medium text-gray-900">{{ $permission->start_date->format('d F Y') }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500">Tanggal Selesai</p>
                <p class="font-medium text-gray-900">{{ $permission->end_date->format('d F Y') }}</p>
            </div>
            <div class="col-span-2">
                <p class="text-xs text-gray-500">Status</p>
                <p class="font-medium">
                    <span class="px-2 py-0.5 rounded-full text-xs font-medium
                        @if($permission->status == 'disetujui') bg-green-100 text-green-700
                        @elseif($permission->status == 'ditolak') bg-red-100 text-red-700
                        @else bg-yellow-100 text-yellow-700 @endif">
                        {{ ucfirst($permission->status) }}
                    </span>
                </p>
            </div>
            <div class="col-span-2">
                <p class="text-xs text-gray-500">Alasan</p>
                <p class="text-sm text-gray-900 mt-1">{{ $permission->reason }}</p>
            </div>
            @if($permission->proof_image)
            <div class="col-span-2">
                <p class="text-xs text-gray-500">Bukti</p>
                <img src="{{ asset('storage/' . $permission->proof_image) }}" class="mt-1 max-w-xs rounded-lg">
            </div>
            @endif
            @if($permission->approved_by)
            <div>
                <p class="text-xs text-gray-500">Disetujui/Ditolak Oleh</p>
                <p class="font-medium text-gray-900">{{ $permission->approver->name }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500">Tanggal Persetujuan</p>
                <p class="font-medium text-gray-900">{{ $permission->approved_at->format('d F Y H:i') }}</p>
            </div>
            @endif
        </div>

        @if(auth()->user()->isAdmin() && $permission->status == 'pending')
        <div class="border-t border-gray-200 pt-4">
            <div class="flex gap-3">
                <form method="POST" action="{{ route('permissions.approve', $permission) }}">
                    @csrf
                    <input type="hidden" name="status" value="disetujui">
                    <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors"
                        onclick="return confirm('Setujui pengajuan ini?')">
                        Setujui
                    </button>
                </form>
                <form method="POST" action="{{ route('permissions.approve', $permission) }}">
                    @csrf
                    <input type="hidden" name="status" value="ditolak">
                    <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors"
                        onclick="return confirm('Tolak pengajuan ini?')">
                        Tolak
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
