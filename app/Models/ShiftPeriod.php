<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShiftPeriod extends Model
{
    use HasFactory;

    protected $table = 'shift_periods';

    protected $fillable = [
        'name',
        'month',
        'week',
        'start_date',
        'end_date',
    ];

    public function schedules()
    {
        return $this->hasMany(ShiftSchedule::class, 'shift_period_id');
    }
}