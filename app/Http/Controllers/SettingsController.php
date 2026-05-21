<?php

namespace App\Http\Controllers;

use App\Models\AttendanceSetting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $setting = AttendanceSetting::first();
        if (!$setting) {
            $setting = AttendanceSetting::create([
                'school_name' => 'Sekolah Saya',
                'check_in_start' => '06:30',
                'check_in_end' => '08:00',
                'check_out_start' => '14:00',
                'check_out_end' => '16:00',
                'late_threshold_minutes' => 15,
                'weekend_enabled' => false,
            ]);
        }

        return view('settings.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'school_name' => 'required|string|max:255',
            'check_in_start' => 'required',
            'check_in_end' => 'required',
            'check_out_start' => 'required',
            'check_out_end' => 'required',
            'late_threshold_minutes' => 'required|integer|min:0|max:120',
            'weekend_enabled' => 'boolean',
        ]);

        $setting = AttendanceSetting::first();
        $setting->update($validated);

        return redirect()->route('settings.index')
            ->with('success', 'Pengaturan absensi berhasil diperbarui.');
    }
}
