<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeanRecap extends Model
{
    use HasFactory;
    protected $table = 'bean_recap';

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
        'income',
        'hpp',
        'total_potongan',
        'potongan_non_investor',
        'profit',
        'desc',
        'status',
        'author'
    ];
}
