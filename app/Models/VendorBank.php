<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorBank extends Model
{
    use HasFactory;
    protected $table = 'vendor_bank';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'account_number',
        'account_name',
        'status'
    ];
}
