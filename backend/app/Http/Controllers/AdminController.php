<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\SupportRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/admin');
        }

        return back()->with('error', 'The provided credentials do not match our records.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/login');
    }

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
