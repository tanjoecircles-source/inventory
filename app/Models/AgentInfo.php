<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentInfo extends Model
{
    use HasFactory;
    protected $table = 'agent';

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
        'user',
        'code',
        'identity_photo',
        'name',
        'gender',
        'place_of_birth',
        'date_of_birth',
        'address',
        'district',
        'region',
        'post_code',
        'bio',
        'author',
        'editor'
    ];

    public function detailUser(){
        return $this->hasOne(User::class, 'id', 'user');
    }
}
