@extends('layouts.app')
@section('title', 'Tambah Lokasi')

@push('styles')
<style>#map { height: 300px; border-radius: 0.75rem; }</style>
@endpush

@section('content')
<div class="p-4 md:p-6 max-w-2xl mx-auto">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Tambah Lokasi Sekolah</h1>
        <p class="text-gray-500 text-sm mt-1">Tentukan lokasi sekolah di peta</p>
    </div>

    <div class="mt-6 bg-white rounded-xl border border-gray-200 p-6 space-y-6">
        <div id="map"></div>

        <form method="POST" action="{{ route('locations.store') }}">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lokasi</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500"
                        placeholder="Nama lokasi">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                    <textarea name="address" rows="2"
                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500"
                        placeholder="Alamat lengkap">{{ old('address') }}</textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Latitude</label>
                        <input type="text" name="latitude" id="input-latitude" value="{{ old('latitude') }}" required
                            class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500"
                            placeholder="-6.123456">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Longitude</label>
                        <input type="text" name="longitude" id="input-longitude" value="{{ old('longitude') }}" required
                            class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500"
                            placeholder="106.123456">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Radius (meter)</label>
                    <input type="number" name="radius" value="{{ old('radius', 50) }}" required min="10" max="1000"
                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                </div>
                <button type="submit" class="w-full py-2.5 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg text-sm transition-colors">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const defaultLat = -6.2088;
    const defaultLng = 106.8456;

    const map = L.map('map').setView([defaultLat, defaultLng], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    let marker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(map);
    let circle = L.circle([defaultLat, defaultLng], { radius: 50, color: '#4f46e5', fillOpacity: 0.1 }).addTo(map);

    document.getElementById('input-latitude').value = defaultLat;
    document.getElementById('input-longitude').value = defaultLng;

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
