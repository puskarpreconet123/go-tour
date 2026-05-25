<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\CmsContent;
use App\Models\SupportRequest;
use App\Models\User;
use App\Models\Destination;
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

    public function updateRequestStatus(Request $request, $id)
    {
        $req = SupportRequest::findOrFail($id);
        $req->update(['status' => $request->status]);
        return back()->with('success', 'Request status updated to ' . $request->status);
    }

    public function updateBookingStatus(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update(['status' => $request->status]);
        return back()->with('success', 'Booking status updated to ' . $request->status);
    }

    public function users()
    {
        $users = User::latest()->get();
        return view('admin.users', compact('users'));
    }

    public function tours()
    {
        $tours = Destination::latest()->get();
        return view('admin.tours', compact('tours'));
    }

    public function winTrip()
    {
        return view('admin.win-trip');
    }

    public function cms()
    {
        $sections = ['about', 'privacy', 'terms'];
        $cmsContents = [];
        foreach ($sections as $section) {
            $row = CmsContent::where('section', $section)->first();
            $cmsContents[$section] = $row ? $row->content : null;
        }
        return view('admin.cms', compact('cmsContents'));
    }

    public function updateCms(Request $request)
    {
        $validated = $request->validate([
            'section' => ['required', 'in:about,privacy,terms'],
            'content' => ['required', 'string'],
        ]);

        CmsContent::updateOrCreate(
            ['section' => $validated['section']],
            ['content' => $validated['content']]
        );

        return response()->json(['success' => true, 'message' => 'Content updated successfully.']);
    }
}
