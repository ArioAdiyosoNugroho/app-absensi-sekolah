@extends('layouts.app')
@section('title', 'Lokasi Sekolah')

@section('content')
<div class="p-4 md:p-6 space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Lokasi Sekolah</h1>
            <p class="text-gray-500 text-sm mt-1">Kelola lokasi sekolah untuk validasi GPS</p>
        </div>
        <a href="{{ route('locations.create') }}" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors">
            + Tambah Lokasi
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @forelse($locations as $location)
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div id="map-{{ $location->id }}" class="h-48" data-lat="{{ $location->latitude }}" data-lng="{{ $location->longitude }}"></div>
            <div class="p-5">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="font-semibold text-gray-900">{{ $location->name }}</h3>
                        <p class="text-sm text-gray-500 mt-1">{{ $location->address ?? 'Tidak ada alamat' }}</p>
                    </div>
                    @if(!$location->is_active)
                    <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700">Nonaktif</span>
                    @endif
                </div>
                <div class="mt-3 text-sm text-gray-600 space-y-1">
                    <p>Latitude: {{ $location->latitude }}</p>
                    <p>Longitude: {{ $location->longitude }}</p>
                    <p>Radius: {{ $location->radius }} meter</p>
                </div>
                <div class="mt-4 flex items-center gap-2">
                    <a href="{{ route('locations.edit', $location) }}"
                        class="px-3 py-1.5 text-sm font-medium text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors">
                        Edit
                    </a>
                    <form method="POST" action="{{ route('locations.destroy', $location) }}"
                        onsubmit="return confirm('Hapus lokasi ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="px-3 py-1.5 text-sm font-medium text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 p-8 text-center text-gray-500">
            Belum ada lokasi sekolah. Tambahkan lokasi pertama.
        </div>
        @endforelse
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('[id^="map-"]').forEach(function(el) {
        if (el.id === 'map') return;
        const lat = parseFloat(el.dataset.lat);
        const lng = parseFloat(el.dataset.lng);
        const map = L.map(el.id).setView([lat, lng], 16);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);
        L.marker([lat, lng]).addTo(map);
        L.circle([lat, lng], {
            radius: 50,
            color: '#4f46e5',
            fillColor: '#4f46e5',
            fillOpacity: 0.1
        }).addTo(map);
    });
});
</script>
@endpush
