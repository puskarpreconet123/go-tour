<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\LuckyDraw;
use App\Models\LuckyDrawTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LuckyDrawController extends Controller
{
    /**
     * Get all active lucky draw campaigns.
     */
    public function index()
    {
        $luckyDraws = LuckyDraw::with('destination')
            ->where('status', 'active')
            ->where('end_date', '>', now())
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $luckyDraws
        ]);
    }

    /**
     * Get details of a specific lucky draw campaign.
     */
    public function show($id)
    {
        $luckyDraw = LuckyDraw::with(['destination', 'winner'])->findOrFail($id);

        // Check if the current user has bought a ticket (if logged in)
        $hasTicket = false;
        $user = Auth::guard('api')->user() ?: auth()->user();
        if ($user) {
            $hasTicket = LuckyDrawTicket::where('lucky_draw_id', $id)
                ->where('user_id', $user->id)
                ->exists();
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'lucky_draw' => $luckyDraw,
                'has_ticket' => $hasTicket
            ]
        ]);
    }

    /**
     * Purchase a ticket for a lucky draw campaign.
     */
    public function buyTicket(Request $request, $id)
    {
        $luckyDraw = LuckyDraw::findOrFail($id);

        if ($luckyDraw->status !== 'active') {
            return response()->json([
                'status' => 'error',
                'message' => 'This lucky draw campaign has already finished.'
            ], 400);
        }

        if (now() > $luckyDraw->end_date) {
            return response()->json([
                'status' => 'error',
                'message' => 'The booking period for this lucky draw has closed.'
            ], 400);
        }

        $user = auth()->user();

        // Create the ticket
        $ticket = LuckyDrawTicket::create([
            'lucky_draw_id' => $luckyDraw->id,
            'user_id' => $user->id
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Ticket purchased successfully!',
            'data' => $ticket
        ]);
    }
}
