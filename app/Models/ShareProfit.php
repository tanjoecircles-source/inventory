<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShareProfit extends Model
{
    use HasFactory;
    protected $table = 'share_profit';

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
        'profit_toko',
        'potongan_non_investor',
        'profit_bean',
        'total_profit',
        'total_share',
        'desc',
        'status',
        'author'
    ];
}
