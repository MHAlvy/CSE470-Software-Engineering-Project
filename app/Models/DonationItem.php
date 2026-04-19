<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'donor_id',
        'title',
        'description',
        'category',
        'status',
        'image_url',
        'expires_at',
    ];

    public function donor()
    {
        return $this->belongsTo(User::class, 'donor_id');
    }

    public function claimRequests()
    {
        return $this->hasMany(ClaimRequest::class, 'donation_id');
    }

    public function deliveryTask()
    {
        return $this->hasOne(DeliveryTask::class, 'donation_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'donation_id');
    }
}