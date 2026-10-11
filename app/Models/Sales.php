<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;
    protected $table = 'sales';

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
        'inv_category',
        'inv_code',
        'inv_date',
        'inv_cust',
        'inv_hpp',
        'inv_sub_total',
        'inv_discount',
        'inv_expedition',
        'inv_shipping_type',
        'inv_ekspedisi_id',
        'inv_resi',
        'inv_total',
        'inv_payment',
        'inv_status_payment',
        'inv_payment_date',
        'inv_payment_type',
        'inv_status',
        'inv_desc',
        'author'
    ];

    public function ekspedisi()
    {
        return $this->belongsTo(Ekspedisi::class, 'inv_ekspedisi_id');
    }
}
