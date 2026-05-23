<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\SupportRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalBookings = Booking::count();
        $totalRequests = SupportRequest::count();
        $recentBookings = Booking::with(['user', 'destination'])->latest()->take(5)->get();

        return view('admin.dashboard', compact('totalUsers', 'totalBookings', 'totalRequests', 'recentBookings'));
    }

    public function bookings()
    {
        $bookings = Booking::with(['user', 'destination'])->latest()->get();
        return view('admin.bookings', compact('bookings'));
    }

    public function requests()
    {
        $requests = SupportRequest::with('user')->latest()->get();
        return view('admin.requests', compact('requests'));
    }
}
