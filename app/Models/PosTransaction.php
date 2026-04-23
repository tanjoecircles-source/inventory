<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosTransaction extends Model
{
    use HasFactory;
    protected $table = 'pos_transactions';
    protected $primaryKey = 'id';

    protected $fillable = [
        'session_id',
        'receipt_no',
        'total_amount',
        'payment_method',
        'cash_amount',
        'qris_amount'
    ];

    public function items()
    {
        return $this->hasMany(PosTransactionItem::class, 'transaction_id', 'id');
    }
}
