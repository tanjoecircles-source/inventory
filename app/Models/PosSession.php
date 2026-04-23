<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosSession extends Model
{
    use HasFactory;
    protected $table = 'pos_sessions';
    protected $primaryKey = 'id';

    protected $fillable = [
        'date',
        'employee_id',
        'shift_id',
        'status',
        'total_cash',
        'total_qris',
        'report_store_id'
    ];

    public function transactions()
    {
        return $this->hasMany(PosTransaction::class, 'session_id', 'id');
    }
}
