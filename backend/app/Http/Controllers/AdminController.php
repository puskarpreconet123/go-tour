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
        // Check for PHP INI file upload size limit failures
        if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_INI_SIZE) {
            return back()->withErrors(['thumbnail' => 'The uploaded thumbnail file exceeds the server\'s upload size limit. Please choose a smaller image (under 2MB) or paste a direct image URL instead.'])->withInput();
        }
        if (isset($_FILES['gallery']['error'])) {
            foreach ($_FILES['gallery']['error'] as $err) {
                if ($err === UPLOAD_ERR_INI_SIZE) {
                    return back()->withErrors(['gallery' => 'One or more gallery files exceed the server\'s upload size limit. Please choose smaller images (under 2MB) or paste direct image URLs instead.'])->withInput();
                }
            }
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:national,international,educational,honeymoon',
            'location' => 'required|string|max:255',
            'short_desc' => 'nullable|string',
            'long_desc' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:20480',
            'image_url' => 'nullable|string|max:2000',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:20480',
            'gallery_urls' => 'nullable|string',
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

        // Handle Thumbnail Upload (prioritizing direct image URL if filled)
        if ($request->filled('image_url')) {
            $data['image_url'] = $request->input('image_url');
        } elseif ($request->hasFile('thumbnail')) {
            try {
                $file = $request->file('thumbnail');
                $path = $file->store('uploads/tours', 'public');
                $data['image_url'] = '/tours/media?file=' . basename($path);
            } catch (\Exception $e) {
                return back()->withErrors(['thumbnail' => 'Failed to save uploaded thumbnail image (Storage write error). Please paste a direct image URL instead.'])->withInput();
            }
        } else {
            $data['image_url'] = 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=800&q=80';
        }

        // Handle Gallery Uploads
        $galleryPaths = [];
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                if ($file->isValid()) {
                    try {
                        $path = $file->store('uploads/tours', 'public');
                        $galleryPaths[] = '/tours/media?file=' . basename($path);
                    } catch (\Exception $e) {
                        return back()->withErrors(['gallery' => 'Failed to save uploaded gallery images (Storage write error). Please paste direct image URLs instead.'])->withInput();
                    }
                }
            }
        }

        // Parse gallery URLs from text area (one per line)
        $urlGallery = [];
        if ($request->filled('gallery_urls')) {
            $urls = explode("\n", $request->input('gallery_urls'));
            foreach ($urls as $url) {
                $url = trim($url);
                if (filter_var($url, FILTER_VALIDATE_URL)) {
                    $urlGallery[] = $url;
                }
            }
        }

        $data['gallery_images'] = array_merge($galleryPaths, $urlGallery);

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

        // Check for PHP INI file upload size limit failures
        if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_INI_SIZE) {
            return back()->withErrors(['thumbnail' => 'The uploaded thumbnail file exceeds the server\'s upload size limit. Please choose a smaller image (under 2MB) or paste a direct image URL instead.'])->withInput();
        }
        if (isset($_FILES['gallery']['error']) && is_array($_FILES['gallery']['error'])) {
            foreach ($_FILES['gallery']['error'] as $err) {
                if ($err === UPLOAD_ERR_INI_SIZE) {
                    return back()->withErrors(['gallery' => 'One or more gallery files exceed the server\'s upload size limit. Please choose smaller images (under 2MB) or paste direct image URLs instead.'])->withInput();
                }
            }
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:national,international,educational,honeymoon',
            'location' => 'required|string|max:255',
            'short_desc' => 'nullable|string',
            'long_desc' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:20480',
            'image_url' => 'nullable|string|max:2000',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:20480',
            'gallery_urls' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ]);

        $data = $request->only(['name', 'location', 'price', 'original_price', 'category', 'short_desc', 'long_desc']);

        // Handle Thumbnail Upload (prioritizing direct image URL if filled and changed)
        if ($request->filled('image_url')) {
            $data['image_url'] = $request->input('image_url');
        } elseif ($request->hasFile('thumbnail')) {
            try {
                $file = $request->file('thumbnail');
                $path = $file->store('uploads/tours', 'public');
                $data['image_url'] = '/tours/media?file=' . basename($path);
            } catch (\Exception $e) {
                return back()->withErrors(['thumbnail' => 'Failed to save uploaded thumbnail image (Storage write error). Please paste a direct image URL instead.'])->withInput();
            }
        }

        // Handle Gallery Uploads
        $existingGallery = is_array($tour->gallery_images) ? $tour->gallery_images : [];
        $newGalleryPaths = [];
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                if ($file->isValid()) {
                    try {
                        $path = $file->store('uploads/tours', 'public');
                        $newGalleryPaths[] = '/tours/media?file=' . basename($path);
                    } catch (\Exception $e) {
                        return back()->withErrors(['gallery' => 'Failed to save uploaded gallery images (Storage write error). Please paste direct image URLs instead.'])->withInput();
                    }
                }
            }
        }

        // Parse gallery URLs from text area (one per line)
        $urlGallery = [];
        if ($request->filled('gallery_urls')) {
            $urls = explode("\n", $request->input('gallery_urls'));
            foreach ($urls as $url) {
                $url = trim($url);
                if (filter_var($url, FILTER_VALIDATE_URL)) {
                    $urlGallery[] = $url;
                }
            }
        }

        if ($request->has('clear_gallery') && $request->input('clear_gallery') == '1') {
            $data['gallery_images'] = $urlGallery;
        } else {
            $data['gallery_images'] = array_merge($existingGallery, $newGalleryPaths, $urlGallery);
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
