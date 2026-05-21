<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\SchoolLocation;
use App\Models\AttendanceSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::where('user_id', Auth::id())
            ->latest()
            ->paginate(15);

        return view('attendance.index', compact('attendances'));
    }

    public function create()
    {
        $todayAttendance = Attendance::where('user_id', Auth::id())
            ->whereDate('date', today())->first();

        $locations = SchoolLocation::active()->get();
        $settings = AttendanceSetting::first();

        return view('attendance.create', compact('todayAttendance', 'locations', 'settings'));
    }

    public function checkIn(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'photo' => 'required|string',
            'location_id' => 'required|exists:school_locations,id',
        ]);

        $location = SchoolLocation::findOrFail($request->location_id);
        $settings = AttendanceSetting::first();

        $distance = $this->calculateDistance(
            $request->latitude,
            $request->longitude,
            $location->latitude,
            $location->longitude
        );

        if ($distance > $location->radius) {
            return response()->json([
                'success' => false,
                'message' => 'Anda berada di luar radius ' . $location->radius . ' meter dari lokasi sekolah. Jarak Anda: ' . round($distance, 1) . ' meter.',
            ]);
        }

        $existing = Attendance::where('user_id', Auth::id())
            ->whereDate('date', today())->first();

        if ($existing && $existing->check_in_time) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah melakukan check in hari ini.',
            ]);
        }

        $photoPath = $this->saveBase64Photo($request->photo, 'check_in');

        $checkInTime = now();
        $status = 'hadir';
        $lateMinutes = 0;

        if ($settings) {
            $checkInEnd = \Carbon\Carbon::parse($settings->check_in_end);
            if ($checkInTime->gt($checkInEnd)) {
                $status = 'terlambat';
                $lateMinutes = $checkInTime->diffInMinutes($checkInEnd);
            }
        }

        $data = [
            'user_id' => Auth::id(),
            'date' => today(),
            'check_in_time' => $checkInTime->format('H:i:s'),
            'check_in_latitude' => $request->latitude,
            'check_in_longitude' => $request->longitude,
            'check_in_photo' => $photoPath,
            'status' => $status,
            'late_minutes' => $lateMinutes,
        ];

        if ($existing) {
            $existing->update($data);
        } else {
            Attendance::create($data);
        }

        return response()->json([
            'success' => true,
            'message' => 'Check in berhasil!',
            'status' => $status,
            'time' => $checkInTime->format('H:i:s'),
            'late_minutes' => $lateMinutes,
        ]);
    }

    public function checkOut(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'photo' => 'required|string',
            'location_id' => 'required|exists:school_locations,id',
        ]);

        $location = SchoolLocation::findOrFail($request->location_id);

        $distance = $this->calculateDistance(
            $request->latitude,
            $request->longitude,
            $location->latitude,
            $location->longitude
        );

        if ($distance > $location->radius) {
            return response()->json([
                'success' => false,
                'message' => 'Anda berada di luar radius ' . $location->radius . ' meter dari lokasi sekolah. Jarak Anda: ' . round($distance, 1) . ' meter.',
            ]);
        }

        $attendance = Attendance::where('user_id', Auth::id())
            ->whereDate('date', today())->first();

        if (!$attendance || !$attendance->check_in_time) {
            return response()->json([
                'success' => false,
                'message' => 'Anda belum melakukan check in hari ini.',
            ]);
        }

        if ($attendance->check_out_time) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah melakukan check out hari ini.',
            ]);
        }

        $photoPath = $this->saveBase64Photo($request->photo, 'check_out');

        $checkOutTime = now();

        $checkInTime = \Carbon\Carbon::parse($attendance->check_in_time);
        $duration = $checkInTime->diffInMinutes($checkOutTime);

        $attendance->update([
            'check_out_time' => $checkOutTime->format('H:i:s'),
            'check_out_latitude' => $request->latitude,
            'check_out_longitude' => $request->longitude,
            'check_out_photo' => $photoPath,
            'duration_minutes' => $duration,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Check out berhasil!',
            'time' => $checkOutTime->format('H:i:s'),
            'duration' => $duration,
        ]);
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000;

        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($lon2);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

        return $angle * $earthRadius;
    }

    private function saveBase64Photo($base64Data, $prefix)
    {
        $imageData = base64_decode($base64Data);

        $filename = $prefix . '_' . Auth::id() . '_' . now()->format('YmdHis') . '.jpg';
        $path = 'attendance/' . $filename;

        Storage::disk('public')->put($path, $imageData);

        return $path;
    }

    public function report(Request $request)
    {
        $query = Attendance::with('user');

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('date', '<=', $request->date_to);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $attendances = $query->latest()->paginate(20);
        $users = User::whereIn('role', ['murid', 'guru'])->get();

        return view('attendance.report', compact('attendances', 'users'));
    }
}
