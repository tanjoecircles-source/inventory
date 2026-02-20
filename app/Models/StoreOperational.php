<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreOperational extends Model
{
    use HasFactory;
    protected $table = 'store_operational';

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
        'op_category',
        'op_code',
        'op_date',
        'op_vendor',
        'op_sub_total',
        'op_discount',
        'op_total',
        'op_payment',
        'op_status_payment',
        'op_payment_date',
        'op_status'
    ];
}
