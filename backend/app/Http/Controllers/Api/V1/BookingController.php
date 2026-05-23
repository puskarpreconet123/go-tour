<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        // Fetch only bookings for the authenticated user
        $query = Booking::with('destination')->where('user_id', auth()->id());

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $bookings = $query->get();

        return response()->json([
            'status' => 'success',
            'data' => $bookings
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'destination_id' => 'nullable|exists:destinations,id',
            'total_amount' => 'numeric',
            'booking_details' => 'nullable|array'
        ]);

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'destination_id' => $request->destination_id,
            'type' => $request->type,
            'status' => 'upcoming',
            'total_amount' => $request->total_amount ?? 0,
            'booking_details' => $request->booking_details
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Booking created successfully',
            'data' => $booking
        ], 201);
    }

    public function show($id)
    {
        $booking = Booking::with('destination')->find($id);

        if (!$booking) {
            return response()->json([
                'status' => 'error',
                'message' => 'Booking not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $booking
        ]);
    }
}
