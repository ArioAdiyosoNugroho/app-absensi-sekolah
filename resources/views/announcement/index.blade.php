@extends('layouts.app')
@section('title', 'Pengumuman')

@section('content')
<div class="p-4 md:p-6 space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Pengumuman</h1>
            <p class="text-gray-500 text-sm mt-1">Daftar pengumuman sekolah</p>
        </div>
        @if(auth()->user()->isAdmin() || auth()->user()->isGuru())
        <a href="{{ route('announcements.create') }}" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors">
            + Buat Pengumuman
        </a>
        @endif
    </div>

    <div class="space-y-4">
        @forelse($announcements as $announcement)
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-900">{{ $announcement->title }}</h3>
                    <div class="flex items-center gap-3 mt-2 text-xs text-gray-400">
                        <span>Oleh: {{ $announcement->creator->name }}</span>
                        <span>{{ $announcement->created_at->format('d F Y H:i') }}</span>
                        <span class="px-2 py-0.5 rounded-full bg-gray-100 text-gray-600">
                            @if($announcement->target_role == 'all') Semua
                            @elseif($announcement->target_role == 'guru') Guru
                            @else Murid @endif
                        </span>
                        @if(!$announcement->is_active)
                        <span class="px-2 py-0.5 rounded-full bg-red-100 text-red-600">Nonaktif</span>
                        @endif
                    </div>
                    <p class="text-sm text-gray-600 mt-3">{{ Str::limit($announcement->content, 300) }}</p>
                </div>
                @if(auth()->user()->isAdmin() || auth()->user()->isGuru())
                <div class="flex items-center gap-2 ml-4">
                    <a href="{{ route('announcements.edit', $announcement) }}" class="p-2 text-gray-400 hover:text-indigo-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </a>
                    <form method="POST" action="{{ route('announcements.destroy', $announcement) }}"
                        onsubmit="return confirm('Hapus pengumuman ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="p-2 text-gray-400 hover:text-red-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </form>
                </div>
                @endif
            </div>
        </div>
        @empty
        <div class="bg-white rounded-xl border border-gray-200 p-8 text-center text-gray-500">
            Belum ada pengumuman
        </div>
        @endforelse
    </div>

    @if($announcements->hasPages())
    <div>
        {{ $announcements->links() }}
    </div>
    @endif
</div>
@endsection
