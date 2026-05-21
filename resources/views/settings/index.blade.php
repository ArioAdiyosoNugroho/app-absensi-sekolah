@extends('layouts.app')
@section('title', 'Pengaturan')

@section('content')
<div class="p-4 md:p-6 max-w-2xl mx-auto">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Pengaturan Absensi</h1>
        <p class="text-gray-500 text-sm mt-1">Atur jadwal dan aturan absensi sekolah</p>
    </div>

    <div class="mt-6 bg-white rounded-xl border border-gray-200 p-6">
        <form method="POST" action="{{ route('settings.update') }}">
            @csrf @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Sekolah</label>
                    <input type="text" name="school_name" value="{{ old('school_name', $setting->school_name) }}" required
                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jam Mulai Check In</label>
                        <input type="time" name="check_in_start" value="{{ old('check_in_start', \Carbon\Carbon::parse($setting->check_in_start)->format('H:i')) }}" required
                            class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jam Akhir Check In</label>
                        <input type="time" name="check_in_end" value="{{ old('check_in_end', \Carbon\Carbon::parse($setting->check_in_end)->format('H:i')) }}" required
                            class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jam Mulai Check Out</label>
                        <input type="time" name="check_out_start" value="{{ old('check_out_start', \Carbon\Carbon::parse($setting->check_out_start)->format('H:i')) }}" required
                            class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jam Akhir Check Out</label>
                        <input type="time" name="check_out_end" value="{{ old('check_out_end', \Carbon\Carbon::parse($setting->check_out_end)->format('H:i')) }}" required
                            class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Batas Keterlambatan (menit)</label>
                    <input type="number" name="late_threshold_minutes" value="{{ old('late_threshold_minutes', $setting->late_threshold_minutes) }}" required min="0" max="120"
                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                    <p class="text-xs text-gray-400 mt-1">Setelah jam akhir check in, akan dianggap terlambat</p>
                </div>

                <label class="flex items-center gap-2">
                    <input type="checkbox" name="weekend_enabled" value="1" {{ $setting->weekend_enabled ? 'checked' : '' }}
                        class="rounded border-gray-300 text-indigo-600">
                    <span class="text-sm text-gray-700">Aktifkan absensi di akhir pekan</span>
                </label>

                <button type="submit" class="w-full py-2.5 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg text-sm transition-colors">
                    Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
