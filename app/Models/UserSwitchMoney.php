<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSwitchMoney extends Model
{
    use HasFactory;
    protected $table = 'user_switch_money';
    protected $primaryKey = 'id';
    protected $fillable = [
        'switch_money_id',
        'user_name',
        'date',
        'amount',
        'type'
    ];

    public function master()
    {
        return $this->belongsTo(SwitchMoney::class, 'switch_money_id');
    }
}
