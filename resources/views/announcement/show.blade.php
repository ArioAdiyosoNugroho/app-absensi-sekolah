@extends('layouts.app')
@section('title', $announcement->title)

@section('content')
<div class="p-4 md:p-6 max-w-3xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('announcements.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">&larr; Kembali</a>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h1 class="text-2xl font-bold text-gray-900">{{ $announcement->title }}</h1>
        <div class="flex items-center gap-3 mt-2 text-sm text-gray-400">
            <span>Oleh: {{ $announcement->creator->name }}</span>
            <span>{{ $announcement->created_at->format('d F Y H:i') }}</span>
            <span class="px-2 py-0.5 rounded-full bg-gray-100 text-gray-600 text-xs">
                @if($announcement->target_role == 'all') Semua
                @elseif($announcement->target_role == 'guru') Guru
                @else Murid @endif
            </span>
        </div>
        <div class="mt-6 text-gray-700 leading-relaxed whitespace-pre-wrap">
            {{ $announcement->content }}
        </div>
    </div>
</div>
@endsection
