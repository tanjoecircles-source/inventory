<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerInfo extends Model
{
    use HasFactory;
    protected $table = 'seller';

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
        'identity_dealer_photo',
        'name',
        'gender',
        'place_of_birth',
        'date_of_birth',
        'dealer_name',
        'dealer_position',
        'dealer_photo_ouside',
        'dealer_photo_inside',
        'dealer_photo_other',
        'dealer_status',
        'dealer_phone',
        'address',
        'district',
        'region',
        'post_code',
        'author',
        'editor'
    ];

    public function detailDistrict(){
        return $this->hasOne(District::class, 'id', 'district');
    }
    
    public function detailRegion(){
        return $this->hasOne(Region::class, 'id', 'region');
    }

    public function detailUser(){
        return $this->hasOne(User::class, 'id', 'user');
    }
}
