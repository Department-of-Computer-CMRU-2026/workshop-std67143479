<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workshop extends Model
{
    protected $fillable = [
        'title',
        'description',
        'instructor',
        'max_seats',
        'scheduled_at',
        'image_url',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
    ];

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function participants()
    {
        return $this->belongsToMany(User::class , 'registrations');
    }

    public function isFull()
    {
        return $this->registrations()->count() >= $this->max_seats;
    }

    public function remainingSeats()
    {
        return max(0, $this->max_seats - $this->registrations()->count());
    }
}
