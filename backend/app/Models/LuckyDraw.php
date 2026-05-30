<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LuckyDraw extends Model
{
    use HasFactory;

    protected $fillable = [
        'destination_id',
        'ticket_price',
        'start_date',
        'end_date',
        'status',
        'winner_id',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    // Get the associated package/destination
    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    // Get the winner of the draw
    public function winner()
    {
        return $this->belongsTo(User::class, 'winner_id');
    }

    // Get all tickets purchased for this draw
    public function tickets()
    {
        return $this->hasMany(LuckyDrawTicket::class);
    }
}
