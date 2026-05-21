<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Absensi</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #4f46e5; color: white; }
        h1 { font-size: 18px; margin-bottom: 5px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header p { margin: 2px 0; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ App\Models\AttendanceSetting::first()->school_name ?? 'Laporan Absensi' }}</h1>
        <p>Laporan Absensi Periode: {{ request('date_from', 'Awal') }} - {{ request('date_to', 'Akhir') }}</p>
        <p>Tanggal Cetak: {{ now()->format('d F Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Role</th>
                <th>Tanggal</th>
                <th>Check In</th>
                <th>Check Out</th>
                <th>Status</th>
                <th>Keterlambatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendances as $index => $attendance)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $attendance->user->name }}</td>
                <td>{{ ucfirst($attendance->user->role) }}</td>
                <td>{{ $attendance->date->format('d/m/Y') }}</td>
                <td>{{ $attendance->check_in_time ? \Carbon\Carbon::parse($attendance->check_in_time)->format('H:i') : '-' }}</td>
                <td>{{ $attendance->check_out_time ? \Carbon\Carbon::parse($attendance->check_out_time)->format('H:i') : '-' }}</td>
                <td>{{ ucfirst($attendance->status) }}</td>
                <td>{{ $attendance->late_minutes > 0 ? $attendance->late_minutes . ' menit' : '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
