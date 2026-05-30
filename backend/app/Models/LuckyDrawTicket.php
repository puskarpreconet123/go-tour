<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LuckyDrawTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'lucky_draw_id',
        'user_id',
    ];

    // Get the associated lucky draw campaign
    public function luckyDraw()
    {
        return $this->belongsTo(LuckyDraw::class);
    }

    // Get the user who bought this ticket
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
