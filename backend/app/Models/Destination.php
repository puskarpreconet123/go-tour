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
        'short_desc',
        'long_desc',
        'gallery_images',
        'meta_data',
    ];

    protected $casts = [
        'gallery_images' => 'array',
        'meta_data' => 'array',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
