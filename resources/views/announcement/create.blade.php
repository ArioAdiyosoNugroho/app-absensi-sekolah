@extends('layouts.app')
@section('title', 'Buat Pengumuman')

@section('content')
<div class="p-4 md:p-6 max-w-2xl mx-auto">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Buat Pengumuman</h1>
        <p class="text-gray-500 text-sm mt-1">Buat pengumuman baru untuk warga sekolah</p>
    </div>

    <div class="mt-6 bg-white rounded-xl border border-gray-200 p-6">
        <form method="POST" action="{{ route('announcements.store') }}">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
                    <input type="text" name="title" value="{{ old('title') }}" required
                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500"
                        placeholder="Judul pengumuman">
                    @error('title')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Target</label>
                    <select name="target_role" required
                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                        <option value="all" {{ old('target_role') == 'all' ? 'selected' : '' }}>Semua</option>
                        <option value="guru" {{ old('target_role') == 'guru' ? 'selected' : '' }}>Guru</option>
                        <option value="murid" {{ old('target_role') == 'murid' ? 'selected' : '' }}>Murid</option>
                    </select>
                    @error('target_role')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Konten</label>
                    <textarea name="content" rows="8" required
                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500"
                        placeholder="Tulis pengumuman di sini...">{{ old('content') }}</textarea>
                    @error('content')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>

                <button type="submit" class="w-full py-2.5 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg text-sm transition-colors">
                    Publikasikan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
