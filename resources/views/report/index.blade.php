@extends('layouts.app')
@section('title', 'Laporan Absensi')

@section('content')
<div class="p-4 md:p-6 space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Laporan Absensi</h1>
        <p class="text-gray-500 text-sm mt-1">Filter, lihat, dan export laporan absensi</p>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <form method="GET" action="{{ route('reports.index') }}" class="grid grid-cols-1 md:grid-cols-6 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Pengguna</label>
                <select name="user_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                    <option value="">Semua</option>
                    @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }} ({{ ucfirst($user->role) }})
                    </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                <select name="role" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                    <option value="">Semua</option>
                    <option value="murid" {{ request('role') == 'murid' ? 'selected' : '' }}>Murid</option>
                    <option value="guru" {{ request('role') == 'guru' ? 'selected' : '' }}>Guru</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                    <option value="">Semua</option>
                    <option value="hadir" {{ request('status') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                    <option value="terlambat" {{ request('status') == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                    <option value="izin" {{ request('status') == 'izin' ? 'selected' : '' }}>Izin</option>
                    <option value="sakit" {{ request('status') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                    <option value="alpha" {{ request('status') == 'alpha' ? 'selected' : '' }}>Alpha</option>
                </select>
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                    Filter
                </button>
                <a href="{{ route('reports.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors">
                    Reset
                </a>
            </div>
        </form>

        <div class="mt-4 flex items-center gap-3 border-t border-gray-100 pt-4">
            <p class="text-sm text-gray-600">Export:</p>
            <a href="{{ route('reports.pdf', request()->query()) }}"
                class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors">
                PDF
            </a>
            <a href="{{ route('reports.excel', request()->query()) }}"
                class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors">
                Excel
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-left text-gray-500">
                        <th class="p-4 font-medium">Nama</th>
                        <th class="p-4 font-medium">Role</th>
                        <th class="p-4 font-medium">NIS/NIP</th>
                        <th class="p-4 font-medium">Tanggal</th>
                        <th class="p-4 font-medium">Check In</th>
                        <th class="p-4 font-medium">Check Out</th>
                        <th class="p-4 font-medium">Status</th>
                        <th class="p-4 font-medium">Keterlambatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendances as $attendance)
                    <tr class="border-t border-gray-100 hover:bg-gray-50">
                        <td class="p-4 font-medium text-gray-900">{{ $attendance->user->name }}</td>
                        <td class="p-4 capitalize">{{ $attendance->user->role }}</td>
                        <td class="p-4 text-gray-500">{{ $attendance->user->nis ?? $attendance->user->nip ?? '-' }}</td>
                        <td class="p-4">{{ $attendance->date->format('d/m/Y') }}</td>
                        <td class="p-4">{{ $attendance->check_in_time ? \Carbon\Carbon::parse($attendance->check_in_time)->format('H:i') : '-' }}</td>
                        <td class="p-4">{{ $attendance->check_out_time ? \Carbon\Carbon::parse($attendance->check_out_time)->format('H:i') : '-' }}</td>
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
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="p-8 text-center text-gray-500">Tidak ada data</td>
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
