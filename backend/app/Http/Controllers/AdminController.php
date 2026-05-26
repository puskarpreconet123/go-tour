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

    public function storeTour(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:national,international,educational,honeymoon',
            'location' => 'required|string|max:255',
            'short_desc' => 'nullable|string',
            'long_desc' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
            'image_url' => 'nullable|string|max:1000',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
            'meta_title' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ]);

        $data = $request->only(['name', 'location', 'price', 'original_price', 'category', 'short_desc', 'long_desc']);
        $data['type'] = 'place';

        // Ensure directory exists
        $uploadPath = public_path('uploads/tours');
        if (!is_dir($uploadPath)) {
            @mkdir($uploadPath, 0755, true);
        }

        // Handle Thumbnail Upload
        if ($request->hasFile('thumbnail')) {
            try {
                $file = $request->file('thumbnail');
                $filename = time() . '_thumb_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($uploadPath, $filename);
                $data['image_url'] = '/uploads/tours/' . $filename;
            } catch (\Exception $e) {
                if ($request->filled('image_url')) {
                    $data['image_url'] = $request->input('image_url');
                } else {
                    $data['image_url'] = 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=800&q=80';
                }
            }
        } elseif ($request->filled('image_url')) {
            $data['image_url'] = $request->input('image_url');
        } else {
            $data['image_url'] = 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=800&q=80';
        }

        // Handle Gallery Uploads
        $galleryPaths = [];
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                if ($file->isValid()) {
                    try {
                        $filename = time() . '_gal_' . uniqid() . '.' . $file->getClientOriginalExtension();
                        $file->move($uploadPath, $filename);
                        $galleryPaths[] = '/uploads/tours/' . $filename;
                    } catch (\Exception $e) {
                        // Suppress write errors
                    }
                }
            }
        }
        $data['gallery_images'] = $galleryPaths;

        // Handle SEO Meta Data
        $data['meta_data'] = [
            'meta_title' => $request->input('meta_title'),
            'meta_description' => $request->input('meta_description'),
            'meta_keywords' => $request->input('meta_keywords'),
        ];

        Destination::create($data);

        return redirect('/admin/tours')->with('success', 'Tour Package created successfully!');
    }

    public function updateTour(Request $request, $id)
    {
        $tour = Destination::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:national,international,educational,honeymoon',
            'location' => 'required|string|max:255',
            'short_desc' => 'nullable|string',
            'long_desc' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
            'image_url' => 'nullable|string|max:1000',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
            'meta_title' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ]);

        $data = $request->only(['name', 'location', 'price', 'original_price', 'category', 'short_desc', 'long_desc']);

        $uploadPath = public_path('uploads/tours');
        if (!is_dir($uploadPath)) {
            @mkdir($uploadPath, 0755, true);
        }

        // Handle Thumbnail Upload
        if ($request->hasFile('thumbnail')) {
            try {
                $file = $request->file('thumbnail');
                $filename = time() . '_thumb_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($uploadPath, $filename);
                $data['image_url'] = '/uploads/tours/' . $filename;
            } catch (\Exception $e) {
                if ($request->filled('image_url')) {
                    $data['image_url'] = $request->input('image_url');
                }
            }
        } elseif ($request->filled('image_url')) {
            $data['image_url'] = $request->input('image_url');
        }

        // Handle Gallery Uploads
        $existingGallery = is_array($tour->gallery_images) ? $tour->gallery_images : [];
        if ($request->hasFile('gallery')) {
            $newGalleryPaths = [];
            foreach ($request->file('gallery') as $file) {
                if ($file->isValid()) {
                    try {
                        $filename = time() . '_gal_' . uniqid() . '.' . $file->getClientOriginalExtension();
                        $file->move($uploadPath, $filename);
                        $newGalleryPaths[] = '/uploads/tours/' . $filename;
                    } catch (\Exception $e) {
                        // Suppress write errors
                    }
                }
            }
            $data['gallery_images'] = array_merge($existingGallery, $newGalleryPaths);
        } else {
            // Check if user requested clearing or keeping
            if ($request->has('clear_gallery') && $request->input('clear_gallery') == '1') {
                $data['gallery_images'] = [];
            } else {
                $data['gallery_images'] = $existingGallery;
            }
        }

        // Handle SEO Meta Data
        $data['meta_data'] = [
            'meta_title' => $request->input('meta_title'),
            'meta_description' => $request->input('meta_description'),
            'meta_keywords' => $request->input('meta_keywords'),
        ];

        $tour->update($data);

        return redirect('/admin/tours')->with('success', 'Tour Package updated successfully!');
    }

    public function deleteTour($id)
    {
        $tour = Destination::findOrFail($id);
        $tour->delete();
        return redirect('/admin/tours')->with('success', 'Tour Package deleted successfully!');
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
