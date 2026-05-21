@extends('layouts.app')
@section('title', 'Dashboard Murid')

@section('content')
<div class="p-4 md:p-6 space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Dashboard Murid</h1>
        <p class="text-gray-500 text-sm mt-1">Selamat datang, {{ auth()->user()->name }}!</p>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <p class="text-sm text-gray-500">Hadir Bulan Ini</p>
            <p class="text-2xl font-bold text-green-600 mt-1">{{ $totalHadirBulanIni }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <p class="text-sm text-gray-500">Izin/Sakit</p>
            <p class="text-2xl font-bold text-yellow-600 mt-1">{{ $totalIzinSakitBulanIni }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <p class="text-sm text-gray-500">Terlambat</p>
            <p class="text-2xl font-bold text-orange-600 mt-1">{{ $totalTerlambatBulanIni }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <p class="text-sm text-gray-500">Alpha</p>
            <p class="text-2xl font-bold text-red-600 mt-1">{{ $totalAlpha }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200">
        <div class="p-5 border-b border-gray-200">
            <h3 class="font-semibold text-gray-900">Status Absensi Hari Ini</h3>
        </div>
        <div class="p-5">
            @if($todayAttendance)
                @if($todayAttendance->check_in_time && $todayAttendance->check_out_time)
                <div class="flex items-center gap-4 p-4 bg-green-50 rounded-lg">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="font-medium text-green-800">Absensi Lengkap</p>
                        <p class="text-sm text-green-600">Check In: {{ \Carbon\Carbon::parse($todayAttendance->check_in_time)->format('H:i') }} | Check Out: {{ \Carbon\Carbon::parse($todayAttendance->check_out_time)->format('H:i') }}</p>
                    </div>
                </div>
                @elseif($todayAttendance->check_in_time)
                <div class="flex items-center gap-4 p-4 bg-yellow-50 rounded-lg">
                    <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="font-medium text-yellow-800">Check In: {{ \Carbon\Carbon::parse($todayAttendance->check_in_time)->format('H:i') }}</p>
                        <p class="text-sm text-yellow-600">Belum check out</p>
                    </div>
                </div>
                @endif
            @else
                <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg">
                    <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="font-medium text-gray-800">Belum Absen</p>
                        <p class="text-sm text-gray-500">Anda belum melakukan absensi hari ini</p>
                    </div>
                </div>
            @endif
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
