<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoastingItem extends Model
{
    use HasFactory;
    protected $table = 'roasting_item';

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
        'roasting_id',
        'profile',
        'product',
        'qty',
        'artisan_log',
        'author'
    ];
}
