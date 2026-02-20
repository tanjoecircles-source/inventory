<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etalase extends Model
{
    use HasFactory;
    protected $table = 'etalase';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product',
        'agent',
        'status',
        'author'
    ];

    public function detailAgent(){
        return $this->hasOne(AgentInfo::class, 'id', 'agent');
    }

    public function detailProduct(){
        return $this->hasOne(Product::class, 'id', 'product');
    }
}
