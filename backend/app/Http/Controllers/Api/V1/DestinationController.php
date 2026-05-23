<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    public function index(Request $request)
    {
        $query = Destination::query();

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        $destinations = $query->get();

        return response()->json([
            'status' => 'success',
            'data' => $destinations
        ]);
    }

    public function show($id)
    {
        $destination = Destination::find($id);

        if (!$destination) {
            return response()->json([
                'status' => 'error',
                'message' => 'Destination not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $destination
        ]);
    }
}
