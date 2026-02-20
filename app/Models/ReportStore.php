<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportStore extends Model
{
    use HasFactory;
    protected $table = 'report_store';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'employee_id',
        'shift_id',
        'date',
        'cash',
        'qris',
        'total',
        'spending',
        'pay',
        'is_saved',
        'status',
        'author'
    ];
}
