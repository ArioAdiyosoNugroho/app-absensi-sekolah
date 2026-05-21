@extends('layouts.app')
@section('title', 'Dashboard Guru')

@section('content')
<div class="p-4 md:p-6 space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Dashboard Guru</h1>
        <p class="text-gray-500 text-sm mt-1">Selamat datang, {{ auth()->user()->name }}!</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Absensi Hari Ini</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">
                        {{ $todayAttendance ? ($todayAttendance->check_in_time ? 'Sudah Absen' : 'Belum Absen') : 'Belum Absen' }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            @if($todayAttendance && $todayAttendance->check_in_time)
            <p class="text-xs text-gray-400 mt-2">Check in: {{ \Carbon\Carbon::parse($todayAttendance->check_in_time)->format('H:i') }}</p>
            @endif
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Hadir Bulan Ini</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalHadirBulanIni }} Hari</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Terlambat Bulan Ini</p>
                    <p class="text-2xl font-bold text-orange-600 mt-1">{{ $totalTerlambatBulanIni }} Kali</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200">
        <div class="p-5 border-b border-gray-200">
            <h3 class="font-semibold text-gray-900">Aksi Cepat</h3>
        </div>
        <div class="p-5">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <a href="{{ route('attendance.create') }}" class="flex items-center gap-3 p-4 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition-colors">
                    <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-indigo-700">Absensi Hari Ini</p>
                        <p class="text-xs text-indigo-500">Lakukan absensi sekarang</p>
                    </div>
                </a>
                <a href="{{ route('permissions.create') }}" class="flex items-center gap-3 p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors">
                    <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-yellow-700">Izin / Sakit</p>
                        <p class="text-xs text-yellow-500">Ajukan izin atau sakit</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    @if($announcements->count() > 0)
    <div class="bg-white rounded-xl border border-gray-200">
        <div class="p-5 border-b border-gray-200">
            <h3 class="font-semibold text-gray-900">Pengumuman</h3>
        </div>
        <div class="p-5 space-y-3">
            @foreach($announcements as $announcement)
            <div class="p-4 bg-gray-50 rounded-lg">
                <h4 class="font-medium text-gray-900">{{ $announcement->title }}</h4>
                <p class="text-sm text-gray-600 mt-1">{{ Str::limit($announcement->content, 200) }}</p>
                <p class="text-xs text-gray-400 mt-2">{{ $announcement->created_at->diffForHumans() }}</p>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
