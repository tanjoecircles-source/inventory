<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchasing extends Model
{
    use HasFactory;
    protected $table = 'purchasing';

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
        'pur_category',
        'pur_code',
        'pur_date',
        'pur_vendor',
        'pur_sub_total',
        'pur_discount',
        'pur_total',
        'pur_payment',
        'pur_status_payment',
        'pur_payment_date',
        'pur_status'
    ];
}
