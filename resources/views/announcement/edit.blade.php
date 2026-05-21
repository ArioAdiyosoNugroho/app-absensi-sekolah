@extends('layouts.app')
@section('title', 'Edit Pengumuman')

@section('content')
<div class="p-4 md:p-6 max-w-2xl mx-auto">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Edit Pengumuman</h1>
        <p class="text-gray-500 text-sm mt-1">Edit pengumuman yang sudah ada</p>
    </div>

    <div class="mt-6 bg-white rounded-xl border border-gray-200 p-6">
        <form method="POST" action="{{ route('announcements.update', $announcement) }}">
            @csrf @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
                    <input type="text" name="title" value="{{ old('title', $announcement->title) }}" required
                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Target</label>
                    <select name="target_role" required
                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                        <option value="all" {{ $announcement->target_role == 'all' ? 'selected' : '' }}>Semua</option>
                        <option value="guru" {{ $announcement->target_role == 'guru' ? 'selected' : '' }}>Guru</option>
                        <option value="murid" {{ $announcement->target_role == 'murid' ? 'selected' : '' }}>Murid</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Konten</label>
                    <textarea name="content" rows="8" required
                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">{{ old('content', $announcement->content) }}</textarea>
                </div>

                <label class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" value="1" {{ $announcement->is_active ? 'checked' : '' }}
                        class="rounded border-gray-300 text-indigo-600">
                    <span class="text-sm text-gray-700">Aktif</span>
                </label>

                <button type="submit" class="w-full py-2.5 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg text-sm transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
