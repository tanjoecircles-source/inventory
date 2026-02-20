<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaristaFeeEmployee extends Model
{
    use HasFactory;
    protected $table = 'barista_fee_employee';

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
        'bf_id',
        'employee_id',
        'shift_short',
        'shift_long',
        'sub_total',
        'potongan',
        'total',
        'desc',
        'payment_status',
        'payment_date',
        'author'
    ];
}
