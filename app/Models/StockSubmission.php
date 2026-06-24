<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockSubmission extends Model
{
    use HasFactory;

    protected $table = 'stock_submissions';

    protected $fillable = [
        'user_id',
        'author',
        'type',
        'date',
        'status',
        'notes',
        'submitted_at'
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'date' => 'date',
    ];

    const STATUS_DRAFT = 'Draft';
    const STATUS_PENDING = 'Menunggu Persetujuan';
    const STATUS_APPROVED = 'Disetujui';
    const STATUS_REJECTED = 'Ditolak';

    public function items()
    {
        return $this->hasMany(StockSubmissionItem::class, 'submission_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}