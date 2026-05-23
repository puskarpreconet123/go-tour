<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'price',
        'original_price',
        'image_url',
        'type',
        'category',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
