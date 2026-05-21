@extends('layouts.app')
@section('title', 'Riwayat Absensi')

@section('content')
<div class="p-4 md:p-6 space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Riwayat Absensi</h1>
            <p class="text-gray-500 text-sm mt-1">Riwayat absensi anda</p>
        </div>
        <a href="{{ route('attendance.create') }}" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors">
            Absensi Hari Ini
        </a>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-left text-gray-500">
                        <th class="p-4 font-medium">Tanggal</th>
                        <th class="p-4 font-medium">Check In</th>
                        <th class="p-4 font-medium">Check Out</th>
                        <th class="p-4 font-medium">Status</th>
                        <th class="p-4 font-medium">Keterlambatan</th>
                        <th class="p-4 font-medium">Durasi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendances as $attendance)
                    <tr class="border-t border-gray-100 hover:bg-gray-50">
                        <td class="p-4 text-gray-900">{{ $attendance->date->format('d/m/Y') }}</td>
                        <td class="p-4">{{ $attendance->check_in_time ? \Carbon\Carbon::parse($attendance->check_in_time)->format('H:i:s') : '-' }}</td>
                        <td class="p-4">{{ $attendance->check_out_time ? \Carbon\Carbon::parse($attendance->check_out_time)->format('H:i:s') : '-' }}</td>
                        <td class="p-4">
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium
                                @if($attendance->status == 'hadir') bg-green-100 text-green-700
                                @elseif($attendance->status == 'terlambat') bg-orange-100 text-orange-700
                                @elseif($attendance->status == 'sakit') bg-yellow-100 text-yellow-700
                                @elseif($attendance->status == 'izin') bg-blue-100 text-blue-700
                                @else bg-gray-100 text-gray-700 @endif">
                                {{ ucfirst($attendance->status) }}
                            </span>
                        </td>
                        <td class="p-4">{{ $attendance->late_minutes > 0 ? $attendance->late_minutes . ' menit' : '-' }}</td>
                        <td class="p-4">{{ $attendance->duration_minutes ? $attendance->duration_minutes . ' menit' : '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-gray-500">Belum ada riwayat absensi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($attendances->hasPages())
        <div class="p-4 border-t border-gray-200">
            {{ $attendances->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
