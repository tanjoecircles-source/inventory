<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockSubmissionItem extends Model
{
    use HasFactory;

    protected $table = 'stock_submission_items';

    protected $fillable = [
        'submission_id',
        'product_id',
        'product_name',
        'quantity',
        'unit',
        'notes'
    ];

    public function submission()
    {
        return $this->belongsTo(StockSubmission::class, 'submission_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}