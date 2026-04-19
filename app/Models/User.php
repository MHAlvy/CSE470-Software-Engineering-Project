<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', 
        'phone',          
        'locationCoordinates',
        'isVerified',      
    ];

    /**
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function donations()
    {
        return $this->hasMany(DonationItem::class, 'donor_id');
    }

    public function claims()
    {
        return $this->hasMany(ClaimRequest::class, 'receiver_id');
    }

    public function deliveries()
    {
        return $this->hasMany(DeliveryTask::class, 'volunteer_id');
    }

    public function receivedReviews()
    {
        return $this->hasMany(Review::class, 'reviewee_id');
    }

    public function getAverageRatingAttribute()
    {
        return number_format($this->receivedReviews()->avg('rating') ?: 0, 1);
    }
}
