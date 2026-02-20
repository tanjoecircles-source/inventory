<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitation extends Model
{
    use HasFactory;

    protected $table = 'visitation';

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
        'code',
        'product',
        'agent',
        'date',
        'time',
        'location',
        'customer_name',
        'customer_address',
        'request',
        'status',
        'author'
    ];

    public function detailProduct(){
        return $this->hasOne(Product::class, 'id', 'product');
    }

    public function detailAgent(){
        return $this->hasOne(AgentInfo::class, 'id', 'agent');
    }
    
    public function detailUser(){
        return $this->hasOne(User::class, 'id', 'author');
    }
}
