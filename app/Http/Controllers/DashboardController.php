<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Permission;
use App\Models\Announcement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return $this->adminDashboard();
        } elseif ($user->isGuru()) {
            return $this->guruDashboard();
        } else {
            return $this->muridDashboard();
        }
    }

    private function adminDashboard()
    {
        $totalMurid = User::where('role', 'murid')->count();
        $totalGuru = User::where('role', 'guru')->count();
        $totalHadirHariIni = Attendance::whereDate('date', today())->count();
        $totalIzinSakitHariIni = Permission::whereDate('created_at', today())
            ->whereIn('status', ['pending', 'disetujui'])->count();
        $totalTerlambatHariIni = Attendance::whereDate('date', today())
            ->where('status', 'terlambat')->count();
        $totalAlphaHariIni = User::where('role', 'murid')
            ->whereDoesntHave('attendances', function ($q) {
                $q->whereDate('date', today());
            })->whereDoesntHave('permissions', function ($q) {
                $q->whereDate('start_date', '<=', today())
                  ->whereDate('end_date', '>=', today())
                  ->whereIn('status', ['disetujui', 'pending']);
            })->count();

        $recentAttendances = Attendance::with('user')
            ->whereDate('date', today())
            ->latest()
            ->take(10)
            ->get();

        $permissionsPending = Permission::with('user')
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        $announcements = Announcement::with('creator')
            ->active()
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.admin', compact(
            'totalMurid', 'totalGuru', 'totalHadirHariIni',
            'totalIzinSakitHariIni', 'totalTerlambatHariIni', 'totalAlphaHariIni',
            'recentAttendances', 'permissionsPending', 'announcements'
        ));
    }

    private function guruDashboard()
    {
        $todayAttendance = Attendance::where('user_id', Auth::id())
            ->whereDate('date', today())->first();

        $totalHadirBulanIni = Attendance::where('user_id', Auth::id())
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->count();

        $totalTerlambatBulanIni = Attendance::where('user_id', Auth::id())
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->where('status', 'terlambat')
            ->count();

        $announcements = Announcement::with('creator')
            ->active()
            ->whereIn('target_role', ['all', 'guru'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.guru', compact(
            'todayAttendance', 'totalHadirBulanIni',
            'totalTerlambatBulanIni', 'announcements'
        ));
    }

    private function muridDashboard()
    {
        $todayAttendance = Attendance::where('user_id', Auth::id())
            ->whereDate('date', today())->first();

        $totalHadirBulanIni = Attendance::where('user_id', Auth::id())
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->count();

        $totalIzinSakitBulanIni = Permission::where('user_id', Auth::id())
            ->whereMonth('start_date', now()->month)
            ->whereYear('start_date', now()->year)
            ->whereIn('status', ['disetujui'])
            ->count();

        $totalTerlambatBulanIni = Attendance::where('user_id', Auth::id())
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->where('status', 'terlambat')
            ->count();

        $totalAlpha = now()->daysInMonth - $totalHadirBulanIni - $totalIzinSakitBulanIni;
        if ($totalAlpha < 0) $totalAlpha = 0;

        $announcements = Announcement::with('creator')
            ->active()
            ->whereIn('target_role', ['all', 'murid'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.murid', compact(
            'todayAttendance', 'totalHadirBulanIni',
            'totalIzinSakitBulanIni', 'totalTerlambatBulanIni',
            'totalAlpha', 'announcements'
        ));
    }
}
