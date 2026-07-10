<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShiftSchedule extends Model
{
    use HasFactory;

    protected $table = 'shift_schedules';

    protected $fillable = [
        'shift_period_id',
        'shift_date',
        'shift1_employee',
        'shift1_type',
        'shift1_start',
        'shift1_end',
        'shift2_employee',
        'shift2_type',
        'shift2_start',
        'shift2_end',
    ];

    public function period()
    {
        return $this->belongsTo(ShiftPeriod::class, 'shift_period_id');
    }
}