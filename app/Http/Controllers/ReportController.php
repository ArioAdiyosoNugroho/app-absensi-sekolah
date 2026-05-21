<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Writer\XLSX\Writer;
use OpenSpout\Common\Entity\Style\Style;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $users = User::whereIn('role', ['murid', 'guru'])->get();

        $query = Attendance::with('user');

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('role')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('role', $request->role);
            });
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

        return view('report.index', compact('attendances', 'users'));
    }

    public function exportPdf(Request $request)
    {
        $attendances = $this->getFilteredData($request);

        $pdf = Pdf::loadView('report.pdf', compact('attendances'));

        return $pdf->download('laporan-absensi-' . now()->format('Y-m-d') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $attendances = $this->getFilteredData($request);

        $writer = new Writer();
        $filename = 'laporan-absensi-' . now()->format('Y-m-d') . '.xlsx';
        $filePath = storage_path('app/public/' . $filename);

        $writer->openToFile($filePath);

        $headerStyle = (new Style())->setFontBold();

        $writer->addRow(Row::fromValues([
            'No', 'Nama', 'Role', 'NIS/NIP', 'Tanggal',
            'Check In', 'Check Out', 'Status', 'Keterlambatan (menit)', 'Durasi (menit)'
        ], $headerStyle));

        foreach ($attendances as $index => $attendance) {
            $writer->addRow(Row::fromValues([
                $index + 1,
                $attendance->user->name,
                ucfirst($attendance->user->role),
                $attendance->user->nis ?? $attendance->user->nip ?? '-',
                $attendance->date->format('d/m/Y'),
                $attendance->check_in_time ?? '-',
                $attendance->check_out_time ?? '-',
                ucfirst($attendance->status),
                $attendance->late_minutes ?? 0,
                $attendance->duration_minutes ?? '-',
            ]));
        }

        $writer->close();

        return response()->download($filePath)->deleteFileAfterSend(true);
    }

    private function getFilteredData(Request $request)
    {
        $query = Attendance::with('user');

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('role')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('role', $request->role);
            });
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

        return $query->latest()->get();
    }
}
