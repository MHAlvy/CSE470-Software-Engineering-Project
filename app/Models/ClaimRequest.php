<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClaimRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'donation_id',
        'receiver_id',
        'justificationNote',
        'status',
    ];

    public function donation()
    {
        return $this->belongsTo(DonationItem::class, 'donation_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}