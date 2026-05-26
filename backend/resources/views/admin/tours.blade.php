@extends('admin.layout')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-3xl font-bold text-slate-800">Manage Tours</h2>
        <p class="text-slate-500 mt-1">Create, update, and manage your tour packages.</p>
    </div>
    <button onclick="openTourDrawer()" class="bg-gradient-to-r from-red-700 to-red-600 hover:from-red-800 hover:to-red-700 text-white font-semibold px-5 py-2.5 rounded-xl transition-all duration-200 shadow-md shadow-red-700/20 flex items-center gap-2">
        <span class="material-symbols-outlined text-lg">add</span>
        Add New Tour
    </button>
</div>

<!-- Tour Packages Grid/Table Card -->
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse whitespace-nowrap min-w-max">
            <thead>
                <tr class="bg-slate-50/75 border-b border-slate-100">
                    <th class="p-4 text-xs font-bold text-slate-400 uppercase tracking-wider pl-6">Tour Package</th>
                    <th class="p-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Category</th>
                    <th class="p-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Location</th>
                    <th class="p-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Pricing (₹)</th>
                    <th class="p-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Gallery</th>
                    <th class="p-4 text-xs font-bold text-slate-400 uppercase tracking-wider pr-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($tours as $tour)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="p-4 pl-6">
                        <div class="flex items-center gap-4">
                            <div class="h-12 w-16 rounded-xl overflow-hidden bg-slate-100 border border-slate-100 flex-shrink-0">
                                <img src="{{ $tour->image_url }}" alt="Thumbnail" class="h-full w-full object-cover">
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 text-sm max-w-[200px] truncate" title="{{ $tour->name }}">{{ $tour->name }}</h4>
                                <span class="text-xs text-slate-400 block truncate max-w-[200px]">{{ $tour->short_desc ?? 'No short description' }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="p-4">
                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full uppercase tracking-wider 
                            @if($tour->category == 'international') bg-teal-50 text-teal-700 border border-teal-100
                            @elseif($tour->category == 'national') bg-sky-50 text-sky-700 border border-sky-100
                            @elseif($tour->category == 'educational') bg-purple-50 text-purple-700 border border-purple-100
                            @else bg-rose-50 text-rose-700 border border-rose-100 @endif">
                            {{ $tour->category ?? 'place' }}
                        </span>
                    </td>
                    <td class="p-4">
                        <div class="flex items-center gap-1.5 text-slate-600 text-sm">
                            <span class="material-symbols-outlined text-slate-400 text-lg">location_on</span>
                            {{ $tour->location }}
                        </div>
                    </td>
                    <td class="p-4">
                        <div class="text-sm font-semibold text-slate-800">₹{{ number_format($tour->price, 2) }}</div>
                        @if($tour->original_price)
                        <div class="text-xs text-slate-400 line-through">₹{{ number_format($tour->original_price, 2) }}</div>
                        @endif
                    </td>
                    <td class="p-4">
                        @if(is_array($tour->gallery_images) && count($tour->gallery_images) > 0)
                        <div class="flex -space-x-2 overflow-hidden">
                            @foreach(array_slice($tour->gallery_images, 0, 3) as $img)
                            <img class="inline-block h-6 w-6 rounded-full ring-2 ring-white object-cover" src="{{ $img }}" alt="Gallery Image">
                            @endforeach
                            @if(count($tour->gallery_images) > 3)
                            <span class="flex items-center justify-center h-6 w-6 rounded-full bg-slate-100 ring-2 ring-white text-[9px] font-bold text-slate-600">+{{ count($tour->gallery_images) - 3 }}</span>
                            @endif
                        </div>
                        @else
                        <span class="text-xs text-slate-400">Empty</span>
                        @endif
                    </td>
                    <td class="p-4 pr-6 text-right">
                        <div class="inline-flex items-center gap-2">
                            <button onclick="showTourDetails({{ json_encode($tour) }})" class="text-slate-600 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 p-2 rounded-xl transition-colors" title="View Details">
                                <span class="material-symbols-outlined text-lg block">visibility</span>
                            </button>
                            <button onclick="editTour({{ json_encode($tour) }})" class="text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 p-2 rounded-xl transition-colors" title="Edit Tour">
                                <span class="material-symbols-outlined text-lg block">edit</span>
                            </button>
                            <button onclick="confirmDeleteTour({{ $tour->id }}, '{{ addslashes($tour->name) }}')" class="text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 p-2 rounded-xl transition-colors" title="Delete Tour">
                                <span class="material-symbols-outlined text-lg block">delete</span>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-12 text-center">
                        <div class="flex flex-col items-center justify-center max-w-sm mx-auto">
                            <div class="bg-red-50 p-4 rounded-full mb-4">
                                <span class="material-symbols-outlined text-4xl text-red-500">tour</span>
                            </div>
                            <h4 class="font-bold text-slate-800 text-lg">No Tour Packages</h4>
                            <p class="text-slate-500 text-sm mt-1">Start by creating your first tour package, which will appear instantly on the mobile app and website.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Tour Action Drawer (Add / Edit) -->
<div id="tour-drawer" class="fixed inset-0 z-50 overflow-hidden hidden">
    <!-- Backing Backdrop -->
    <div class="absolute inset-0 bg-slate-950/60 backdrop-blur-sm transition-opacity" onclick="closeTourDrawer()"></div>
    
    <div class="absolute inset-y-0 right-0 max-w-full flex pl-10">
        <div class="w-screen max-w-2xl bg-white shadow-2xl flex flex-col h-full border-l border-slate-100">
            <!-- Header -->
            <div class="p-6 bg-slate-900 text-white flex justify-between items-center">
                <div>
                    <h3 id="drawer-title" class="text-xl font-bold">Add Tour Package</h3>
                    <p class="text-xs text-slate-400 mt-1">Provide pricing, locations, description, and images.</p>
                </div>
                <button onclick="closeTourDrawer()" class="text-slate-400 hover:text-white transition-colors bg-white/10 rounded-full p-1.5 flex items-center justify-center">
                    <span class="material-symbols-outlined text-sm">close</span>
                </button>
            </div>

            <!-- Scrollable Form Body -->
            <form id="tour-form" action="/admin/tours" method="POST" enctype="multipart/form-data" class="flex-1 overflow-y-auto p-6 space-y-6">
                @csrf
                <input type="hidden" id="tour-id" name="id">

                <!-- Title & Category -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Tour Title *</label>
                        <input type="text" id="form-name" name="name" required placeholder="e.g. Exotic Maldives Escape" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:border-red-500 focus:outline-none">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Category *</label>
                        <select id="form-category" name="category" required class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:border-red-500 focus:outline-none bg-white">
                            <option value="national">National</option>
                            <option value="international">International</option>
                            <option value="educational">Educational</option>
                            <option value="honeymoon">Honeymoon</option>
                        </select>
                    </div>
                </div>

                <!-- Location & Prices -->
                <div class="grid grid-cols-3 gap-4">
                    <div class="col-span-1 space-y-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Location *</label>
                        <input type="text" id="form-location" name="location" required placeholder="e.g. Male, Maldives" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:border-red-500 focus:outline-none">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Package Price (₹) *</label>
                        <input type="number" id="form-price" name="price" required min="0" placeholder="e.g. 45000" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:border-red-500 focus:outline-none">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Original Price (₹)</label>
                        <input type="number" id="form-original-price" name="original_price" min="0" placeholder="e.g. 52000" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:border-red-500 focus:outline-none">
                    </div>
                </div>

                <!-- Short Desc -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Short Description *</label>
                    <textarea id="form-short-desc" name="short_desc" required rows="3" placeholder="Brief summary of the tour package (ideal for lists and preview cards)" class="w-full border border-slate-200 rounded-xl p-4 text-sm focus:border-red-500 focus:outline-none resize-none"></textarea>
                </div>

                <!-- Long Desc -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Long / Detail Description</label>
                    <textarea id="form-long-desc" name="long_desc" rows="6" placeholder="Provide complete travel itinerary, inclusions, exclusions, and stay details..." class="w-full border border-slate-200 rounded-xl p-4 text-sm focus:border-red-500 focus:outline-none"></textarea>
                </div>

                <!-- Thumbnail Selection (Upload OR URL) -->
                <div class="border-t border-slate-100 pt-6 space-y-4">
                    <h4 class="font-bold text-slate-800 text-sm">Thumbnail / Cover Image</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Upload Thumbnail File</label>
                            <input type="file" id="form-thumbnail" name="thumbnail" accept="image/*" onchange="previewFile(this, 'thumb-preview')" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 cursor-pointer">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Or Image URL</label>
                            <input type="text" id="form-image-url" name="image_url" placeholder="https://..." oninput="previewUrl(this.value, 'thumb-preview')" class="w-full border border-slate-200 rounded-xl px-4 py-2 text-sm focus:border-red-500 focus:outline-none">
                        </div>
                    </div>
                    <div class="h-32 w-48 rounded-2xl overflow-hidden bg-slate-50 border border-slate-100 flex items-center justify-center">
                        <img id="thumb-preview" src="https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=800&q=80" alt="Thumbnail Preview" class="h-full w-full object-cover">
                    </div>
                </div>

                <!-- Gallery Multi-Upload -->
                <div class="border-t border-slate-100 pt-6 space-y-4">
                    <div class="flex justify-between items-center">
                        <h4 class="font-bold text-slate-800 text-sm">Gallery Images</h4>
                        <div class="flex items-center gap-2">
                            <input type="checkbox" id="clear-gallery-checkbox" name="clear_gallery" value="1" class="rounded border-slate-350 text-red-700 focus:ring-red-500">
                            <label for="clear-gallery-checkbox" class="text-xs text-red-600 font-semibold cursor-pointer">Clear existing gallery</label>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Upload Multiple Images</label>
                        <input type="file" id="form-gallery" name="gallery[]" accept="image/*" multiple onchange="previewMultipleFiles(this, 'gallery-previews-container')" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 cursor-pointer">
                    </div>
                    <div id="gallery-previews-container" class="flex flex-wrap gap-3">
                        <!-- Preview thumbnails injected here -->
                    </div>
                </div>

                <!-- SEO Section (Meta data) -->
                <div class="border-t border-slate-100 pt-6 space-y-4">
                    <button type="button" onclick="toggleSeoSettings()" class="flex justify-between items-center w-full text-slate-700 hover:text-slate-900 focus:outline-none">
                        <h4 class="font-bold text-slate-800 text-sm flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-slate-500">travel_explore</span>
                            SEO & Search Engine Meta Details
                        </h4>
                        <span id="seo-arrow" class="material-symbols-outlined transition-transform">keyboard_arrow_down</span>
                    </button>
                    <div id="seo-settings-container" class="space-y-4 hidden pt-2">
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Meta Title</label>
                            <input type="text" id="form-meta-title" name="meta_title" placeholder="SEO optimized title (e.g. Affordable Holiday Packages...)" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:border-red-500 focus:outline-none">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Meta Keywords</label>
                            <input type="text" id="form-meta-keywords" name="meta_keywords" placeholder="travel, vacation, maldives packages, budget travel" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:border-red-500 focus:outline-none">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Meta Description</label>
                            <textarea id="form-meta-description" name="meta_description" rows="3" placeholder="Brief SEO description summarizing package details..." class="w-full border border-slate-200 rounded-xl p-4 text-sm focus:border-red-500 focus:outline-none resize-none"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Footer / Action Buttons -->
                <div class="bg-slate-50 border-t border-slate-100 p-6 flex justify-end gap-3 sticky bottom-0 -mx-6 -mb-6">
                    <button type="button" onclick="closeTourDrawer()" class="bg-slate-200 text-slate-800 hover:bg-slate-300 font-semibold px-5 py-2.5 rounded-xl transition-colors text-sm">Cancel</button>
                    <button type="submit" class="bg-gradient-to-r from-red-700 to-red-600 hover:from-red-800 hover:to-red-700 text-white font-semibold px-6 py-2.5 rounded-xl transition-all duration-200 shadow-md shadow-red-700/20 text-sm">Save Package</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Custom Modern Confirm Delete Modal -->
<div id="delete-modal" class="fixed inset-0 z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
    <div class="fixed inset-0 bg-slate-950/60 backdrop-blur-sm" onclick="closeDeleteModal()"></div>
    <div class="bg-white rounded-2xl shadow-2xl z-10 w-full max-w-md mx-4 transform scale-95 transition-transform duration-300 overflow-hidden border border-slate-100">
        <div class="p-6 text-center">
            <div class="w-16 h-16 bg-red-50 text-red-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="material-symbols-outlined text-4xl">delete_forever</span>
            </div>
            <h3 class="text-xl font-bold text-slate-800">Delete Tour Package?</h3>
            <p class="text-slate-500 text-sm mt-2">Are you sure you want to delete <span id="delete-tour-name" class="font-semibold text-slate-800"></span>? This action cannot be undone.</p>
        </div>
        <div class="bg-slate-50 px-6 py-4 flex justify-center gap-3 border-t border-slate-100">
            <button onclick="closeDeleteModal()" class="bg-slate-200 hover:bg-slate-300 text-slate-800 px-5 py-2 rounded-xl font-semibold text-sm transition-colors">Cancel</button>
            <form id="delete-form" action="" method="POST">
                @csrf
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-xl font-semibold text-sm transition-colors shadow-md shadow-red-600/10">Delete</button>
            </form>
        </div>
    </div>
</div>

<script>
    // Toggle SEO Accordion
    function toggleSeoSettings() {
        const seoContainer = document.getElementById('seo-settings-container');
        const arrow = document.getElementById('seo-arrow');
        seoContainer.classList.toggle('hidden');
        if (seoContainer.classList.contains('hidden')) {
            arrow.classList.remove('rotate-180');
        } else {
            arrow.classList.add('rotate-180');
        }
    }

    // Modal Control (Delete Tour)
    const deleteModal = document.getElementById('delete-modal');
    const deleteTourName = document.getElementById('delete-tour-name');
    const deleteForm = document.getElementById('delete-form');

    function confirmDeleteTour(id, name) {
        deleteTourName.textContent = name;
        deleteForm.action = `/admin/tours/${id}/delete`;
        
        deleteModal.classList.remove('hidden');
        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                deleteModal.classList.remove('opacity-0');
                deleteModal.querySelector('.bg-white').classList.remove('scale-95');
                deleteModal.querySelector('.bg-white').classList.add('scale-100');
            });
        });
    }

    function closeDeleteModal() {
        deleteModal.classList.add('opacity-0');
        deleteModal.querySelector('.bg-white').classList.remove('scale-100');
        deleteModal.querySelector('.bg-white').classList.add('scale-95');
        setTimeout(() => {
            deleteModal.classList.add('hidden');
        }, 300);
    }

    // Drawer Control (Add / Edit Tour)
    const tourDrawer = document.getElementById('tour-drawer');
    const drawerTitle = document.getElementById('drawer-title');
    const tourForm = document.getElementById('tour-form');
    const defaultThumbUrl = 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=800&q=80';

    function openTourDrawer() {
        // Clear fields for adding new
        tourForm.action = '/admin/tours';
        drawerTitle.textContent = 'Add Tour Package';
        tourForm.reset();
        document.getElementById('tour-id').value = '';
        document.getElementById('thumb-preview').src = defaultThumbUrl;
        document.getElementById('gallery-previews-container').innerHTML = '';
        document.getElementById('clear-gallery-checkbox').checked = false;

        tourDrawer.classList.remove('hidden');
    }

    function closeTourDrawer() {
        tourDrawer.classList.add('hidden');
    }

    function editTour(tour) {
        tourForm.action = `/admin/tours/${tour.id}/update`;
        drawerTitle.textContent = 'Edit Tour Package';
        
        document.getElementById('tour-id').value = tour.id;
        document.getElementById('form-name').value = tour.name;
        document.getElementById('form-category').value = tour.category || 'national';
        document.getElementById('form-location').value = tour.location;
        document.getElementById('form-price').value = tour.price;
        document.getElementById('form-original-price').value = tour.original_price || '';
        document.getElementById('form-short-desc').value = tour.short_desc || '';
        document.getElementById('form-long-desc').value = tour.long_desc || '';
        document.getElementById('form-image-url').value = tour.image_url.startsWith('/uploads/') ? '' : tour.image_url;
        document.getElementById('thumb-preview').src = tour.image_url;
        document.getElementById('clear-gallery-checkbox').checked = false;

        // SEO Meta Data
        const metadata = tour.meta_data || {};
        document.getElementById('form-meta-title').value = metadata.meta_title || '';
        document.getElementById('form-meta-keywords').value = metadata.meta_keywords || '';
        document.getElementById('form-meta-description').value = metadata.meta_description || '';

        // Existing Gallery Previews
        const galleryContainer = document.getElementById('gallery-previews-container');
        galleryContainer.innerHTML = '';
        if (Array.isArray(tour.gallery_images)) {
            tour.gallery_images.forEach(img => {
                const imgEl = document.createElement('div');
                imgEl.className = 'h-14 w-14 rounded-xl overflow-hidden bg-slate-50 border border-slate-100 flex-shrink-0';
                imgEl.innerHTML = `<img src="${img}" class="h-full w-full object-cover" alt="Gallery Preview">`;
                galleryContainer.appendChild(imgEl);
            });
        }

        tourDrawer.classList.remove('hidden');
    }

    function showTourDetails(tour) {
        const metadata = tour.meta_data || {};
        const detailsData = {
            'ID': '#' + tour.id,
            'Title': tour.name,
            'Category': tour.category ? tour.category.toUpperCase() : 'N/A',
            'Location': tour.location,
            'Package Price': '₹' + parseFloat(tour.price).toLocaleString(),
            'Original Price': tour.original_price ? '₹' + parseFloat(tour.original_price).toLocaleString() : 'N/A',
            'Short Description': tour.short_desc || 'N/A',
            'Long Description': tour.long_desc || 'N/A',
            'Meta Title': metadata.meta_title || 'N/A',
            'Meta Keywords': metadata.meta_keywords || 'N/A',
            'Meta Description': metadata.meta_description || 'N/A'
        };
        showDetailsModal('Tour Package Details', detailsData);
    }

    // Previews on changes
    function previewUrl(url, targetId) {
        const img = document.getElementById(targetId);
        if (url && url.trim() !== '') {
            img.src = url;
        } else {
            img.src = defaultThumbUrl;
        }
    }

    function previewFile(input, targetId) {
        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById(targetId).src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    }

    function previewMultipleFiles(input, containerId) {
        const container = document.getElementById(containerId);
        container.innerHTML = ''; // Clear previews
        
        Array.from(input.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imgWrapper = document.createElement('div');
                imgWrapper.className = 'h-14 w-14 rounded-xl overflow-hidden bg-slate-50 border border-slate-100 flex-shrink-0';
                imgWrapper.innerHTML = `<img src="${e.target.result}" class="h-full w-full object-cover" alt="Gallery Preview">`;
                container.appendChild(imgWrapper);
            }
            reader.readAsDataURL(file);
        });
    }
</script>
@endsection
