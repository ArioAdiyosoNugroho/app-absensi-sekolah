@extends('layouts.app')
@section('title', 'Edit Lokasi')

@push('styles')
<style>#map { height: 300px; border-radius: 0.75rem; }</style>
@endpush

@section('content')
<div class="p-4 md:p-6 max-w-2xl mx-auto">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Edit Lokasi</h1>
        <p class="text-gray-500 text-sm mt-1">{{ $location->name }}</p>
    </div>

    <div class="mt-6 bg-white rounded-xl border border-gray-200 p-6 space-y-6">
        <div id="map"></div>

        <form method="POST" action="{{ route('locations.update', $location) }}">
            @csrf @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lokasi</label>
                    <input type="text" name="name" value="{{ old('name', $location->name) }}" required
                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                    <textarea name="address" rows="2"
                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">{{ old('address', $location->address) }}</textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Latitude</label>
                        <input type="text" name="latitude" id="input-latitude" value="{{ old('latitude', $location->latitude) }}" required
                            class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Longitude</label>
                        <input type="text" name="longitude" id="input-longitude" value="{{ old('longitude', $location->longitude) }}" required
                            class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Radius (meter)</label>
                    <input type="number" name="radius" value="{{ old('radius', $location->radius) }}" required min="10" max="1000"
                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                </div>
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" value="1" {{ $location->is_active ? 'checked' : '' }}
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const lat = {{ $location->latitude }};
    const lng = {{ $location->longitude }};
    const radius = {{ $location->radius }};

    const map = L.map('map').setView([lat, lng], 16);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    let marker = L.marker([lat, lng], { draggable: true }).addTo(map);
    let circle = L.circle([lat, lng], { radius: radius, color: '#4f46e5', fillOpacity: 0.1 }).addTo(map);

    marker.on('dragend', function(e) {
        const latlng = e.target.getLatLng();
        document.getElementById('input-latitude').value = latlng.lat.toFixed(6);
        document.getElementById('input-longitude').value = latlng.lng.toFixed(6);
        circle.setLatLng([latlng.lat, latlng.lng]);
    });

    map.on('click', function(e) {
        marker.setLatLng(e.latlng);
        document.getElementById('input-latitude').value = e.latlng.lat.toFixed(6);
        document.getElementById('input-longitude').value = e.latlng.lng.toFixed(6);
        circle.setLatLng([e.latlng.lat, e.latlng.lng]);
    });

    document.querySelector('input[name="radius"]').addEventListener('input', function() {
        circle.setRadius(parseInt(this.value) || 50);
    });
});
</script>
@endpush
