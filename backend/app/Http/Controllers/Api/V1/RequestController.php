<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\SupportRequest;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    public function index(Request $request)
    {
        $query = SupportRequest::query();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $requests = $query->get();

        return response()->json([
            'status' => 'success',
            'data' => $requests
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'type' => 'required|string', // visa, passport, support
            'notes' => 'nullable|string'
        ]);

        $supportRequest = SupportRequest::create([
            'user_id' => $request->user_id,
            'type' => $request->type,
            'status' => 'pending',
            'notes' => $request->notes
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Request submitted successfully',
            'data' => $supportRequest
        ], 201);
    }
}
