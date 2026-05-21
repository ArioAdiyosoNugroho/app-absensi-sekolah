<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceSetting extends Model
{
    protected $fillable = [
        'school_name',
        'check_in_start',
        'check_in_end',
        'check_out_start',
        'check_out_end',
        'late_threshold_minutes',
        'weekend_enabled',
    ];

    protected function casts(): array
    {
        return [
            'check_in_start' => 'datetime:H:i',
            'check_in_end' => 'datetime:H:i',
            'check_out_start' => 'datetime:H:i',
            'check_out_end' => 'datetime:H:i',
            'late_threshold_minutes' => 'integer',
            'weekend_enabled' => 'boolean',
        ];
    }
}
