<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosTransactionItem extends Model
{
    use HasFactory;
    protected $table = 'pos_transaction_items';
    protected $primaryKey = 'id';

    protected $fillable = [
        'transaction_id',
        'product_id',
        'product_name',
        'price',
        'qty',
        'subtotal'
    ];
}
