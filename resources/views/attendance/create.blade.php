@extends('layouts.app')
@section('title', 'Absensi Hari Ini')

@push('styles')
<style>
    #map { height: 300px; border-radius: 0.75rem; }
    #camera-preview { width: 100%; max-width: 320px; border-radius: 0.75rem; }
    .photo-preview { width: 128px; height: 128px; object-fit: cover; border-radius: 0.75rem; }
</style>
@endpush

@section('content')
<div class="p-4 md:p-6 max-w-3xl mx-auto space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Absensi Hari Ini</h1>
        <p class="text-gray-500 text-sm mt-1">{{ now()->format('l, d F Y') }}</p>
    </div>

    @if($todayAttendance && $todayAttendance->check_in_time && $todayAttendance->check_out_time)
    <div class="bg-white rounded-xl border border-gray-200 p-6 text-center">
        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <h2 class="text-xl font-semibold text-gray-900">Absensi Lengkap</h2>
        <p class="text-gray-500 mt-1">Anda sudah melakukan absensi hari ini</p>
        <div class="mt-4 grid grid-cols-2 gap-4 max-w-sm mx-auto">
            <div class="p-3 bg-gray-50 rounded-lg">
                <p class="text-xs text-gray-500">Check In</p>
                <p class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($todayAttendance->check_in_time)->format('H:i:s') }}</p>
            </div>
            <div class="p-3 bg-gray-50 rounded-lg">
                <p class="text-xs text-gray-500">Check Out</p>
                <p class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($todayAttendance->check_out_time)->format('H:i:s') }}</p>
            </div>
        </div>
        <a href="{{ route('attendance.index') }}" class="mt-4 inline-block text-sm text-indigo-600 hover:text-indigo-700 font-medium">
            Lihat Riwayat Absensi
        </a>
    </div>
    @else
    <div id="checkin-status" class="bg-white rounded-xl border border-gray-200 p-6 text-center">
        <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
        </div>
        <h2 class="text-xl font-semibold text-gray-900" id="status-title">
            {{ $todayAttendance && $todayAttendance->check_in_time ? 'Siap Check Out' : 'Siap Check In' }}
        </h2>
        <p class="text-gray-500 mt-1" id="status-desc">
            {{ $todayAttendance && $todayAttendance->check_in_time ? 'Silakan lakukan check out' : 'Silakan lakukan check in' }}
        </p>

        <div id="loading-status" class="hidden mt-4">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 rounded-lg">
                <svg class="animate-spin w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg>
                <span class="text-sm text-gray-600">Memeriksa lokasi...</span>
            </div>
        </div>
    </div>

    <div id="attendance-form" class="bg-white rounded-xl border border-gray-200 p-6 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="font-medium text-gray-900 mb-3">Lokasi Anda</h3>
                <div id="map"></div>
                <div id="location-info" class="mt-3 space-y-2">
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span id="location-text">Mendapatkan lokasi...</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span id="distance-text">Menghitung jarak...</span>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="font-medium text-gray-900 mb-3">Foto Selfie</h3>
                <div class="space-y-3">
                    <div id="camera-container" class="bg-gray-100 rounded-xl overflow-hidden">
                        <video id="camera-preview" autoplay playsinline class="hidden"></video>
                        <canvas id="camera-canvas" class="hidden"></canvas>
                        <img id="photo-result" class="photo-preview hidden mx-auto">
                        <div id="camera-placeholder" class="flex flex-col items-center justify-center py-8">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <p class="text-sm text-gray-500 mt-2">Kamera akan aktif otomatis</p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <button type="button" id="capture-btn"
                            class="flex-1 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                            Ambil Foto
                        </button>
                        <button type="button" id="retake-btn"
                            class="py-2 px-4 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors hidden">
                            Ulang
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-200 pt-6">
            <button type="button" id="submit-btn"
                class="w-full py-3 px-6 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed text-base"
                disabled>
                {{ $todayAttendance && $todayAttendance->check_in_time ? 'Check Out' : 'Check In' }}
            </button>
            <p id="error-text" class="text-sm text-red-600 mt-2 text-center hidden"></p>
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    @if(!($todayAttendance && $todayAttendance->check_in_time && $todayAttendance->check_out_time))
    const isCheckOut = {{ $todayAttendance && $todayAttendance->check_in_time ? 'true' : 'false' }};
    const locations = @json($locations);

    let map, marker, circle;
    let currentLat = null, currentLng = null;
    let photoData = null;
    let stream = null;
    let isLocationValid = false;
    let isPhotoTaken = false;
    let isSubmitting = false;

    const mapEl = document.getElementById('map');
    const submitBtn = document.getElementById('submit-btn');
    const errorText = document.getElementById('error-text');
    const locationText = document.getElementById('location-text');
    const distanceText = document.getElementById('distance-text');
    const cameraPreview = document.getElementById('camera-preview');
    const cameraCanvas = document.getElementById('camera-canvas');
    const photoResult = document.getElementById('photo-result');
    const captureBtn = document.getElementById('capture-btn');
    const retakeBtn = document.getElementById('retake-btn');
    const cameraPlaceholder = document.getElementById('camera-placeholder');
    const loadingStatus = document.getElementById('loading-status');

    function initMap(lat, lng) {
        map = L.map(mapEl).setView([lat, lng], 16);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        marker = L.marker([lat, lng], { draggable: false }).addTo(map);
    }

    function updateLocation(lat, lng) {
        currentLat = lat;
        currentLng = lng;
        locationText.textContent = `Lat: ${lat.toFixed(6)}, Lng: ${lng.toFixed(6)}`;

        if (!map) {
            initMap(lat, lng);
        } else {
            marker.setLatLng([lat, lng]);
            map.setView([lat, lng]);
        }

        let nearestLocation = null;
        let nearestDistance = Infinity;

        locations.forEach(loc => {
            const dist = calculateDistance(lat, lng, parseFloat(loc.latitude), parseFloat(loc.longitude));
            if (dist < nearestDistance) {
                nearestDistance = dist;
                nearestLocation = loc;
            }
        });

        if (circle) map.removeLayer(circle);

        if (nearestLocation) {
            circle = L.circle([nearestLocation.latitude, nearestLocation.longitude], {
                radius: nearestLocation.radius,
                color: nearestDistance <= nearestLocation.radius ? '#22c55e' : '#ef4444',
                fillColor: nearestDistance <= nearestLocation.radius ? '#22c55e' : '#ef4444',
                fillOpacity: 0.1
            }).addTo(map);

            L.marker([parseFloat(nearestLocation.latitude), parseFloat(nearestLocation.longitude)], {
                icon: L.divIcon({
                    className: 'school-marker',
                    html: '<div style="background:#4f46e5;color:white;padding:4px 8px;border-radius:4px;font-size:12px;white-space:nowrap;">' + nearestLocation.name + '</div>',
                    iconSize: [80, 20],
                    iconAnchor: [40, 10]
                })
            }).addTo(map);

            if (nearestDistance <= nearestLocation.radius) {
                distanceText.textContent = `Anda berada dalam radius (${nearestDistance.toFixed(1)}m dari ${nearestLocation.name})`;
                distanceText.className = 'text-sm text-green-600';
                isLocationValid = true;
            } else {
                distanceText.textContent = `Anda berada di luar radius (${nearestDistance.toFixed(1)}m - maks ${nearestLocation.radius}m)`;
                distanceText.className = 'text-sm text-red-600';
                isLocationValid = false;
            }
        }

        checkCanSubmit();
    }

    function calculateDistance(lat1, lon1, lat2, lon2) {
        const R = 6371000;
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLon = (lon2 - lon1) * Math.PI / 180;
        const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
            Math.cos(lat1 * Math.PI/180) * Math.cos(lat2 * Math.PI/180) *
            Math.sin(dLon/2) * Math.sin(dLon/2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        return R * c;
    }

    function startCamera() {
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices.getUserMedia({ video: { facingMode: 'user', width: 320, height: 320 } })
                .then(function(s) {
                    stream = s;
                    cameraPreview.srcObject = s;
                    cameraPreview.classList.remove('hidden');
                    cameraPlaceholder.classList.add('hidden');
                    captureBtn.disabled = false;
                })
                .catch(function(err) {
                    cameraPlaceholder.innerHTML = `
                        <svg class="w-12 h-12 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                        <p class="text-sm text-red-500 mt-2">Kamera tidak tersedia</p>
                        <p class="text-xs text-gray-400 mt-1">${err.message}</p>`;
                    captureBtn.disabled = true;
                });
        } else {
            cameraPlaceholder.innerHTML = `
                <svg class="w-12 h-12 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                </svg>
                <p class="text-sm text-red-500 mt-2">Browser tidak mendukung kamera</p>`;
            captureBtn.disabled = true;
        }
    }

    captureBtn.addEventListener('click', function() {
        if (!stream) return;

        cameraCanvas.width = cameraPreview.videoWidth;
        cameraCanvas.height = cameraPreview.videoHeight;
        cameraCanvas.getContext('2d').drawImage(cameraPreview, 0, 0);

        photoData = cameraCanvas.toDataURL('image/jpeg', 0.8).split(',')[1];
        photoResult.src = cameraCanvas.toDataURL('image/jpeg', 0.8);
        photoResult.classList.remove('hidden');

        cameraPreview.classList.add('hidden');
        captureBtn.classList.add('hidden');
        retakeBtn.classList.remove('hidden');

        if (stream) {
            stream.getTracks().forEach(t => t.stop());
            stream = null;
        }

        isPhotoTaken = true;
        checkCanSubmit();
    });

    retakeBtn.addEventListener('click', function() {
        photoData = null;
        photoResult.classList.add('hidden');
        retakeBtn.classList.add('hidden');
        captureBtn.classList.remove('hidden');
        isPhotoTaken = false;
        checkCanSubmit();
        startCamera();
    });

    function checkCanSubmit() {
        if (isLocationValid && isPhotoTaken) {
            submitBtn.disabled = false;
            errorText.classList.add('hidden');
        } else {
            submitBtn.disabled = true;
            let errors = [];
            if (!isLocationValid) errors.push('Lokasi tidak valid');
            if (!isPhotoTaken) errors.push('Foto selfie belum diambil');
            if (errors.length > 0) {
                errorText.textContent = errors.join(', ');
                errorText.classList.remove('hidden');
            }
        }
    }

    submitBtn.addEventListener('click', function() {
        if (isSubmitting) return;
        isSubmitting = true;
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <svg class="animate-spin w-5 h-5 mx-auto" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
            </svg>`;

        const endpoint = isCheckOut ? '{{ route("attendance.checkout") }}' : '{{ route("attendance.checkin") }}';
        const locationId = locations.length > 0 ? locations[0].id : null;

        fetch(endpoint, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                latitude: currentLat,
                longitude: currentLng,
                photo: photoData,
                location_id: locationId
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const statusEl = document.getElementById('checkin-status');
                statusEl.innerHTML = `
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-900">${data.message}</h2>
                    <p class="text-gray-500 mt-1">Pukul ${data.time}${data.late_minutes ? ' (Terlambat ' + data.late_minutes + ' menit)' : ''}</p>
                    <a href="{{ route('attendance.index') }}" class="mt-4 inline-block text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                        Lihat Riwayat Absensi
                    </a>`;
                document.getElementById('attendance-form').remove();
            } else {
                isSubmitting = false;
                errorText.textContent = data.message;
                errorText.classList.remove('hidden');
                submitBtn.disabled = false;
                submitBtn.textContent = isCheckOut ? 'Check Out' : 'Check In';
            }
        })
        .catch(err => {
            isSubmitting = false;
            errorText.textContent = 'Terjadi kesalahan. Silakan coba lagi.';
            errorText.classList.remove('hidden');
            submitBtn.disabled = false;
            submitBtn.textContent = isCheckOut ? 'Check Out' : 'Check In';
        });
    });

    if (navigator.geolocation) {
        loadingStatus.classList.remove('hidden');
        navigator.geolocation.getCurrentPosition(
            function(pos) {
                loadingStatus.classList.add('hidden');
                updateLocation(pos.coords.latitude, pos.coords.longitude);
                startCamera();
            },
            function(err) {
                loadingStatus.classList.add('hidden');
                locationText.textContent = 'Gagal mendapatkan lokasi: ' + err.message;
                distanceText.textContent = 'Aktifkan GPS untuk melanjutkan';
                distanceText.className = 'text-sm text-red-600';
                cameraPlaceholder.innerHTML = `
                    <svg class="w-12 h-12 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <p class="text-sm text-red-500 mt-2">Aktifkan GPS untuk melanjutkan</p>`;
            },
            { enableHighAccuracy: true, timeout: 10000 }
        );
    } else {
        locationText.textContent = 'Browser tidak mendukung GPS';
    }
    @endif
});
</script>
@endpush
