<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'donation_id',
        'volunteer_id',
        'status',
        'pickedUpAt',
        'deliveredAt',
    ];

    public function donation()
    {
        return $this->belongsTo(DonationItem::class, 'donation_id');
    }

    public function volunteer()
    {
        return $this->belongsTo(User::class, 'volunteer_id');
    }
}