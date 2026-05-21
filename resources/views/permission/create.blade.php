@extends('layouts.app')
@section('title', 'Ajukan Izin / Sakit')

@section('content')
<div class="p-4 md:p-6 max-w-2xl mx-auto">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Ajukan Izin / Sakit</h1>
        <p class="text-gray-500 text-sm mt-1">Isi form di bawah untuk mengajukan izin atau sakit</p>
    </div>

    <div class="mt-6 bg-white rounded-xl border border-gray-200 p-6">
        <form method="POST" action="{{ route('permissions.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipe Pengajuan</label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 p-3 border rounded-lg cursor-pointer has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50">
                            <input type="radio" name="type" value="izin" {{ old('type') == 'izin' ? 'checked' : '' }} required>
                            <span class="text-sm font-medium">Izin</span>
                        </label>
                        <label class="flex items-center gap-2 p-3 border rounded-lg cursor-pointer has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50">
                            <input type="radio" name="type" value="sakit" {{ old('type') == 'sakit' ? 'checked' : '' }} required>
                            <span class="text-sm font-medium">Sakit</span>
                        </label>
                    </div>
                    @error('type')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                        <input type="date" name="start_date" value="{{ old('start_date') }}" required
                            class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                        @error('start_date')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                        <input type="date" name="end_date" value="{{ old('end_date') }}" required
                            class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                        @error('end_date')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alasan</label>
                    <textarea name="reason" rows="4" required
                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500"
                        placeholder="Jelaskan alasan izin atau sakit...">{{ old('reason') }}</textarea>
                    @error('reason')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bukti (Foto)</label>
                    <input type="file" name="proof_image" accept="image/jpg,image/jpeg,image/png"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    <p class="text-xs text-gray-400 mt-1">Format: JPG, JPEG, PNG. Maks: 2MB (Opsional)</p>
                    @error('proof_image')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>

                <button type="submit" class="w-full py-2.5 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg text-sm transition-colors">
                    Ajukan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
