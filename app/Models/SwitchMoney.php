<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SwitchMoney extends Model
{
    use HasFactory;
    protected $table = 'switch_money';
    protected $primaryKey = 'id';
    protected $fillable = [
        'date',
        'from_bank_id',
        'to_bank_id',
        'user_id',
        'amount',
        'fee',
        'total',
        'status',
        'note',
        'author',
        'editor'
    ];

    public function from_bank()
    {
        return $this->belongsTo(VendorBank::class, 'from_bank_id');
    }

    public function to_bank()
    {
        return $this->belongsTo(VendorBank::class, 'to_bank_id');
    }

    public function items()
    {
        return $this->hasMany(UserSwitchMoney::class, 'switch_money_id');
    }

    public function user_author()
    {
        return $this->belongsTo(User::class, 'author');
    }

    public function user_editor()
    {
        return $this->belongsTo(User::class, 'editor');
    }
}
