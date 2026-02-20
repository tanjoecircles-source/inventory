<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class productHpp extends Model
{
    use HasFactory;
    protected $table = 'product_hpp';

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
        'prod_id',
        'nama_gb_1',
        'nama_gb_2',
        'harga_gb_1',
        'harga_gb_2',
        'cargo_1',
        'cargo_2',
        'roasting_1',
        'roasting_2',
        'loss_1',
        'loss_2',
        'ratio_1',
        'ratio_2',
        'netto',
        'pack',
        'box',
        'hpp_total',
    ];
}
