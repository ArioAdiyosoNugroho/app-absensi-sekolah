<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\AttendanceSetting;
use App\Models\SchoolLocation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Sekolah',
            'email' => 'admin@sekolah.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Guru Budi',
            'email' => 'guru@sekolah.com',
            'password' => Hash::make('password'),
            'role' => 'guru',
            'nip' => '1987654321',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Murid Andi',
            'email' => 'murid@sekolah.com',
            'password' => Hash::make('password'),
            'role' => 'murid',
            'nis' => '1234567890',
            'is_active' => true,
        ]);

        AttendanceSetting::create([
            'school_name' => 'SMA Negeri 1 Smart',
            'check_in_start' => '06:30',
            'check_in_end' => '08:00',
            'check_out_start' => '14:00',
            'check_out_end' => '16:00',
            'late_threshold_minutes' => 15,
            'weekend_enabled' => false,
        ]);
    }
}
