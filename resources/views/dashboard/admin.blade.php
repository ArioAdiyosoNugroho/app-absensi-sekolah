@extends('layouts.app')
@section('title', 'Dashboard Admin')

@section('content')
<div class="p-4 md:p-6 space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Dashboard Admin</h1>
        <p class="text-gray-500 text-sm mt-1">Selamat datang, {{ auth()->user()->name }}!</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Murid</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalMurid }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/></svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Guru</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalGuru }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Hadir Hari Ini</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalHadirHariIni }}</p>
                </div>
                <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Terlambat</p>
                    <p class="text-2xl font-bold text-orange-600 mt-1">{{ $totalTerlambatHariIni }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Izin / Sakit Hari Ini</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalIzinSakitHariIni }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Alpha Hari Ini</p>
                    <p class="text-2xl font-bold text-red-600 mt-1">{{ $totalAlphaHariIni }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Pengajuan Pending</p>
                    <p class="text-2xl font-bold text-purple-600 mt-1">{{ $permissionsPending->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl border border-gray-200">
            <div class="p-5 border-b border-gray-200">
                <h3 class="font-semibold text-gray-900">Absensi Hari Ini</h3>
            </div>
            <div class="p-5">
                @if($recentAttendances->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-gray-500 border-b border-gray-100">
                                <th class="pb-2 font-medium">Nama</th>
                                <th class="pb-2 font-medium">Check In</th>
                                <th class="pb-2 font-medium">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentAttendances as $attendance)
                            <tr class="border-b border-gray-50">
                                <td class="py-2.5">{{ $attendance->user->name }}</td>
                                <td class="py-2.5">{{ $attendance->check_in_time ? \Carbon\Carbon::parse($attendance->check_in_time)->format('H:i') : '-' }}</td>
                                <td class="py-2.5">
                                    <span class="px-2 py-0.5 rounded-full text-xs font-medium
                                        @if($attendance->status == 'hadir') bg-green-100 text-green-700
                                        @elseif($attendance->status == 'terlambat') bg-orange-100 text-orange-700
                                        @elseif($attendance->status == 'sakit') bg-yellow-100 text-yellow-700
                                        @elseif($attendance->status == 'izin') bg-blue-100 text-blue-700
                                        @else bg-gray-100 text-gray-700 @endif">
                                        {{ ucfirst($attendance->status) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-gray-500 text-sm text-center py-4">Belum ada absensi hari ini</p>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200">
            <div class="p-5 border-b border-gray-200">
                <h3 class="font-semibold text-gray-900">Pengajuan Izin/Sakit Pending</h3>
            </div>
            <div class="p-5">
                @if($permissionsPending->count() > 0)
                <div class="space-y-3">
                    @foreach($permissionsPending as $permission)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $permission->user->name }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">{{ ucfirst($permission->type) }} -
                                {{ $permission->start_date->format('d/m') }} - {{ $permission->end_date->format('d/m/Y') }}</p>
                        </div>
                        <a href="{{ route('permissions.show', $permission) }}"
                           class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">Lihat</a>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-gray-500 text-sm text-center py-4">Tidak ada pengajuan pending</p>
                @endif
            </div>
        </div>
    </div>

    @if($announcements->count() > 0)
    <div class="bg-white rounded-xl border border-gray-200">
        <div class="p-5 border-b border-gray-200">
            <h3 class="font-semibold text-gray-900">Pengumuman Terbaru</h3>
        </div>
        <div class="p-5">
            <div class="space-y-3">
                @foreach($announcements as $announcement)
                <div class="p-4 bg-gray-50 rounded-lg">
                    <h4 class="font-medium text-gray-900">{{ $announcement->title }}</h4>
                    <p class="text-sm text-gray-600 mt-1">{{ Str::limit($announcement->content, 150) }}</p>
                    <div class="flex items-center gap-3 mt-2 text-xs text-gray-400">
                        <span>Oleh: {{ $announcement->creator->name }}</span>
                        <span>{{ $announcement->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
