<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreRecap extends Model
{
    use HasFactory;
    protected $table = 'store_recap';

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
        'periode_id',
        'income_cash',
        'income_qris',
        'income_total',
        'outcome_operational',
        'outcome_purchasing',
        'outcome_cash',
        'outcome_barista',
        'outcome_total',
        'profit',
        'desc',
        'status',
        'author'
    ];
}
