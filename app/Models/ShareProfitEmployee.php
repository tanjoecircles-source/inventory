<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShareProfitEmployee extends Model
{
    use HasFactory;
    protected $table = 'share_profit_employee';

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
        'sp_id',
        'employee_id',
        'sub_total',
        'tabungan_credit',
        'potongan',
        'total',
        'desc',
        'payment_status',
        'payment_date',
        'author'
    ];
}
