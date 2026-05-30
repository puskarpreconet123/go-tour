// Centralized configuration for Go Tour API connection
const API_BASE_URL = 'https://go-tour-backend.onrender.com/api/v1';

// Utility to get image URL (if it is a local upload path, prepend backend base URL, otherwise return as is)
function getImageUrl(url, name = '') {
    const lowercaseName = String(name).toLowerCase();

    // Check if it is an uploaded image on Render (which is temporary and gets deleted on spin-downs)
    // If so, fall back to our local high-quality static assets for predefined tours
    const isRenderUpload = !url || url.startsWith('/uploads/') || url.startsWith('/tours/media');

    if (isRenderUpload) {
        if (lowercaseName.includes('switzerland') || lowercaseName.includes('swiss')) {
            return 'assets/images/img16.jpg';
        }
        if (lowercaseName.includes('dubai')) {
            return 'assets/images/img2.jpg';
        }
        if (lowercaseName.includes('kashmir')) {
            return 'assets/images/img10.jpg';
        }
        if (lowercaseName.includes('bali')) {
            return 'assets/images/img1.jpg';
        }
        if (lowercaseName.includes('japan')) {
            return 'assets/images/img3.jpg';
        }
        if (lowercaseName.includes('france') || lowercaseName.includes('paris')) {
            return 'assets/images/img9.jpg';
        }
    }

    if (!url) return 'assets/images/placeholder.jpg';
    if (url.startsWith('/uploads/') || url.startsWith('/tours/media')) {
        return `https://go-tour-backend.onrender.com${url}`;
    }
    return url;
}

// Fetch all destinations from the backend
async function fetchDestinations(filters = {}) {
    try {
        const queryParams = new URLSearchParams(filters).toString();
        const response = await fetch(`${API_BASE_URL}/destinations?${queryParams}`);
        if (!response.ok) throw new Error('Failed to fetch destinations');
        const data = await response.json();
        return data.data || [];
    } catch (error) {
        console.error('Error fetching destinations:', error);
        return [];
    }
}

// Fetch single destination details
async function fetchDestination(id) {
    try {
        const response = await fetch(`${API_BASE_URL}/destinations/${id}`);
        if (!response.ok) throw new Error('Failed to fetch destination details');
        const data = await response.json();
        return data.data;
    } catch (error) {
        console.error(`Error fetching destination ${id}:`, error);
        return null;
    }
}

// Initialize components based on current page
document.addEventListener('DOMContentLoaded', () => {
    // Dynamic navigation links based on auth status
    if (typeof updateNavigationHeader === 'function') {
        updateNavigationHeader();
    }

    const path = window.location.pathname;

    if (path.endsWith('index.html') || path === '/' || path.endsWith('/')) {
        initHomePage();
    } else if (path.endsWith('destination.html')) {
        initDestinationsPage();
    } else if (path.endsWith('package-detail.html')) {
        initPackageDetailPage();
    }
});

// Home Page Rendering
async function initHomePage() {
    // 1. Render Trending Packages (regular places)
    const packageSection = document.querySelector('.package-section');
    if (packageSection) {
        const places = await fetchDestinations({ type: 'place' });
        if (places.length > 0) {
            // Keep the "VIEW ALL PACKAGES" button block and replace just the list of articles
            const btnWrap = packageSection.querySelector('.section-btn-wrap');
            packageSection.innerHTML = ''; // Clear static items

            places.forEach(place => {
                const duration = place.meta_data?.duration || 'N/A';
                const pax = place.meta_data?.pax || 'N/A';
                const img = getImageUrl(place.image_url, place.name);

                const article = document.createElement('article');
                article.className = 'package-item';
                article.innerHTML = `
                    <figure class="package-image" style="background-image: url(${img});"></figure>
                    <div class="package-content">
                       <h3>
                          <a href="package-detail.html?id=${place.id}">
                             ${place.name}
                          </a>
                       </h3>
                       <p>${place.short_desc || ''}</p>
                       <div class="package-meta">
                          <ul>
                             <li>
                                <i class="fas fa-clock"></i>
                                ${duration}
                             </li>
                             <li>
                                <i class="fas fa-user-friends"></i>
                                ${pax}
                             </li>
                             <li>
                                <i class="fas fa-map-marker-alt"></i>
                                ${place.location || ''}
                             </li>
                          </ul>
                       </div>
                    </div>
                    <div class="package-price">
                       <h6 class="price-list">
                          <span>₹${parseFloat(place.price).toLocaleString()}</span>
                          / per person
                       </h6>
                       ${typeof isAuthenticated !== 'undefined' && isAuthenticated()
                        ? `<a href="booking.html?id=${place.id}" class="outline-btn outline-btn-white">Book now</a>`
                        : `<a href="login.html?redirect=booking.html?id=${place.id}" class="outline-btn outline-btn-white">Login to Book</a>`
                    }
                    </div>
                `;
                packageSection.appendChild(article);
            });
            if (btnWrap) {
                packageSection.appendChild(btnWrap);
            }
        }
    }

    // 2. Render Limited Time Deals (deals)
    const offerSectionRow = document.querySelector('.offer-section .row');
    if (offerSectionRow) {
        const deals = await fetchDestinations({ type: 'deal' });
        if (deals.length > 0) {
            offerSectionRow.innerHTML = ''; // Clear static items

            deals.forEach(deal => {
                const duration = deal.meta_data?.duration || 'N/A';
                const pax = deal.meta_data?.pax || 'N/A';
                const img = getImageUrl(deal.image_url, deal.name);

                // Calculate percentage discount
                let discountHtml = '';
                if (deal.original_price && deal.original_price > deal.price) {
                    const discount = Math.round(((deal.original_price - deal.price) / deal.original_price) * 100);
                    discountHtml = `<div class="offer-badge">UPTO <span>${discount}%</span> off</div>`;
                }

                const col = document.createElement('div');
                col.className = 'col-md-6';
                col.innerHTML = `
                    <article class="offer-item" style="background-image: url(${img});">
                       ${discountHtml}
                       <div class="offer-content">
                          <div class="package-meta">
                             <ul>
                                <li>
                                   <i class="fas fa-clock"></i>
                                   ${duration}
                                </li>
                                <li>
                                   <i class="fas fa-user-friends"></i>
                                   ${pax}
                                </li>
                                <li>
                                   <i class="fas fa-map-marker-alt"></i>
                                   ${deal.location || ''}
                                </li>
                             </ul>
                          </div>
                          <h3>
                             <a href="package-detail.html?id=${deal.id}">${deal.name}</a>
                          </h3>
                          <p>${deal.short_desc || ''}</p>
                          <div class="price-list">
                             price: 
                             ${deal.original_price ? `<del>₹${parseFloat(deal.original_price).toLocaleString()} </del>` : ''}
                             <ins>₹${parseFloat(deal.price).toLocaleString()}</ins>
                          </div>
                          ${typeof isAuthenticated !== 'undefined' && isAuthenticated()
                        ? `<a href="booking.html?id=${deal.id}" class="round-btn">Book Now</a>`
                        : `<a href="login.html?redirect=booking.html?id=${deal.id}" class="round-btn">Login to Book</a>`
                    }
                       </div>
                    </article>
                `;
                offerSectionRow.appendChild(col);
            });
        }
    }

    // 3. Render Popular Travel Destinations
    const destinationSectionRow = document.querySelector('.destination-section .row');
    if (destinationSectionRow) {
        const popularDestinations = await fetchDestinations();
        if (popularDestinations.length > 0) {
            destinationSectionRow.innerHTML = ''; // Clear static items

            // Limit to top 3 items
            popularDestinations.slice(0, 3).forEach(dest => {
                const img = getImageUrl(dest.image_url, dest.name);
                const col = document.createElement('div');
                col.className = 'col-lg-4 col-md-6';
                col.innerHTML = `
                    <article class="destination-item" style="background-image: url(${img});">
                       <a href="package-detail.html?id=${dest.id}">
                          <div class="destination-content">
                             <div class="rating-start-wrap">
                                <div class="rating-start">
                                   <span style="width: 100%"></span>
                                </div>
                             </div>
                             <span class="cat-link">${(dest.category || 'destination').toUpperCase()}</span>
                             <h3>${dest.name}</h3>
                             <p>${dest.short_desc || ''}</p>
                          </div>
                       </a>
                    </article>
                `;
                destinationSectionRow.appendChild(col);
            });
        }
    }
}

// Destinations Page Rendering
async function initDestinationsPage() {
    const destinationsContainer = document.querySelector('#destinations-container') || document.querySelector('.destination-item-wrap .row');
    if (destinationsContainer) {
        // Set id for consistency
        destinationsContainer.id = 'destinations-container';

        const allDestinations = await fetchDestinations();
        if (allDestinations.length > 0) {
            destinationsContainer.innerHTML = '';

            allDestinations.forEach(dest => {
                const img = getImageUrl(dest.image_url, dest.name);
                const col = document.createElement('div');
                col.className = 'col-lg-4 col-md-6';
                col.innerHTML = `
                    <article class="destination-item" style="background-image: url(${img});">
                       <a href="package-detail.html?id=${dest.id}">
                          <div class="destination-content">
                             <div class="rating-start-wrap">
                                <div class="rating-start">
                                   <span style="width: 100%"></span>
                                </div>
                             </div>
                             <span class="cat-link">${(dest.category || 'destination').toUpperCase()}</span>
                             <h3>${dest.name}</h3>
                             <p>${dest.short_desc || ''}</p>
                          </div>
                       </a>
                    </article>
                `;
                destinationsContainer.appendChild(col);
            });
        }
    }
}

// Package Details Page Rendering
async function initPackageDetailPage() {
    const urlParams = new URLSearchParams(window.location.search);
    const packageId = urlParams.get('id');
    if (!packageId) {
        console.warn('No package ID specified in URL. Showing default package or redirecting.');
        return;
    }

    const pkg = await fetchDestination(packageId);
    if (!pkg) {
        console.error('Package not found.');
        return;
    }

    // Bind page title, package title, and pricing
    const pageTitle = document.querySelector('.page-title');
    if (pageTitle) pageTitle.textContent = pkg.name;

    const titleEl = document.querySelector('.package-title h2');
    if (titleEl) titleEl.textContent = pkg.name;

    const priceEl = document.querySelector('.package-price .price-list');
    if (priceEl) {
        priceEl.innerHTML = `
            <span>₹${parseFloat(pkg.price).toLocaleString()}</span>
            / per person
        `;
    }

    // Bind package meta details (duration, pax, category, location)
    const metaList = document.querySelector('.package-meta ul');
    if (metaList) {
        const duration = pkg.meta_data?.duration || 'N/A';
        const pax = pkg.meta_data?.pax || 'N/A';

        metaList.innerHTML = `
            <li>
                <i class="fas fa-clock"></i>
                ${duration}
            </li>
            <li>
                <i class="fas fa-user-friends"></i>
                ${pax}
            </li>
            <li>
                <i class="fas fa-swimmer"></i>
                Category : ${(pkg.category || 'N/A').toUpperCase()}
            </li>
            <li>
                <i class="fas fa-map-marker-alt"></i>
                ${pkg.location || ''}
            </li>
        `;
    }

    // Bind main cover image (forcing exact same dimensions via inline styles to bypass CSS cache)
    const mainImg = document.querySelector('.single-package-image img');
    const mainImgContainer = document.querySelector('.single-package-image');
    if (mainImg) {
        mainImg.src = getImageUrl(pkg.image_url, pkg.name);
        mainImg.style.width = '100%';
        mainImg.style.height = '100%';
        mainImg.style.objectFit = 'cover';
        mainImg.style.objectPosition = 'center';
        mainImg.style.borderRadius = '25px';
    }
    if (mainImgContainer) {
        mainImgContainer.style.height = '480px';
        mainImgContainer.style.overflow = 'hidden';
        mainImgContainer.style.borderRadius = '25px';
    }

    // Bind dynamic HTML long description (CKEditor contents with automatic styling layout parser)
    const contentDetail = document.querySelector('.package-content-detail');
    if (contentDetail) {
        if (pkg.long_desc) {
            contentDetail.innerHTML = parseRichDescription(pkg.long_desc);
        } else {
            contentDetail.innerHTML = `<p>${pkg.short_desc || 'No description available.'}</p>`;
        }
    }

    // Update booking form action/redirection or set hidden fields if necessary
    const bookingForm = document.querySelector('.booking-form');
    if (bookingForm) {
        const bookingSubmitBtn = bookingForm.querySelector('button[type="submit"]');
        const loggedIn = typeof isAuthenticated !== 'undefined' && isAuthenticated();
        if (bookingSubmitBtn) {
            bookingSubmitBtn.textContent = loggedIn ? 'ENQUIRY NOW' : 'LOGIN TO BOOK';
        }
        bookingForm.addEventListener('submit', (e) => {
            e.preventDefault();
            if (loggedIn) {
                window.location.href = `booking.html?id=${pkg.id}`;
            } else {
                window.location.href = `login.html?redirect=booking.html?id=${pkg.id}`;
            }
        });
    }

    // Bind related gallery images from admin-uploaded gallery_images
    const relatedSlide = document.querySelector('.related-package-slide');
    if (relatedSlide) {
        const galleryImages = pkg.gallery_images || [];
        if (galleryImages.length > 0) {
            // Check if slick was already initialized
            const $slide = $('.related-package-slide');
            if ($slide.hasClass('slick-initialized')) {
                $slide.slick('unslick');
            }
            
            relatedSlide.innerHTML = '';
            
            galleryImages.forEach(imgUrl => {
                const img = getImageUrl(imgUrl);
                const item = document.createElement('div');
                item.className = 'related-package-item';
                item.innerHTML = `<img src="${img}" alt="Gallery Image" style="border-radius: 25px; width: 100%; height: 200px; object-fit: cover;">`;
                relatedSlide.appendChild(item);
            });
            
            // Re-initialize slick slider
            $slide.slick({
                dots: true,
                infinite: true,
                speed: 1000,
                prevArrow: false,
                nextArrow: false,
                slidesToShow: Math.min(2, galleryImages.length),
                autoplay: true
            });
        } else {
            // Hide the related section if no gallery images are available
            const relatedWrap = document.querySelector('.related-package');
            if (relatedWrap) {
                relatedWrap.style.display = 'none';
            }
        }
    }
}

// Automatically parses plain/CKEditor description text and structures it into theme-styled modules in original order
function parseRichDescription(html) {
    const parser = new DOMParser();
    const doc = parser.parseFromString(html, 'text/html');

    let resultHtml = '';
    let itineraryIndex = 0;

    const elements = Array.from(doc.body.children);

    elements.forEach(el => {
        const tagName = el.tagName.toUpperCase();

        if (tagName === 'UL') {
            // Unordered list -> Include & Exclude style
            let includeItemsHtml = '';
            const items = el.querySelectorAll('li');
            items.forEach(li => {
                const liText = li.textContent.trim();
                if (!liText) return;

                const isExclude = /fee|expense|dirham|private|exclude|not\s+included|visa|tax|flight|own/i.test(liText);
                const iconClass = isExclude ? 'fas fa-times' : 'fas fa-check';
                const colorClass = isExclude ? 'text-danger' : 'text-success';

                includeItemsHtml += `
                    <li style="margin-bottom: 12px; width: 50%; display: flex; align-items: center; gap: 8px;">
                        <i class="${iconClass} ${colorClass}" style="font-size: 13px; min-width: 15px;"></i>
                        <span>${liText}</span>
                    </li>`;
            });

            resultHtml += `
                <article class="package-include bg-light-grey" style="padding: 30px 40px; margin: 25px 0; background: #f8f9fa; border-radius: 25px;">
                    <ul style="display: flex; flex-wrap: wrap; list-style: none; padding-left: 0; margin-bottom: 0; width: 100%;">
                        ${includeItemsHtml}
                    </ul>
                </article>
            `;
        } else if (tagName === 'OL') {
            // Ordered list -> Itinerary style
            let itineraryItemsHtml = '';
            const items = el.querySelectorAll('li');
            items.forEach(li => {
                itineraryItemsHtml += formatItineraryItem(li.innerHTML, itineraryIndex++);
            });

            resultHtml += `
                <article class="package-ininerary" style="margin: 25px 0;">
                    <ul style="list-style: none; padding-left: 0; margin-bottom: 0;">
                        ${itineraryItemsHtml}
                    </ul>
                </article>
            `;
        } else if (['H1', 'H2', 'H3', 'H4', 'H5', 'H6'].includes(tagName)) {
            // Render headings with Montserrat font and blue color like the main package headers
            let fontSize = '22px';
            if (tagName === 'H1') fontSize = '32px';
            else if (tagName === 'H2') fontSize = '28px';
            else if (tagName === 'H3') fontSize = '22px';
            else if (tagName === 'H4') fontSize = '18px';
            else if (tagName === 'H5') fontSize = '16px';

            resultHtml += `<${tagName} style="font-family: 'Montserrat', sans-serif; font-weight: 700; color: #223645; margin-top: 30px; margin-bottom: 15px; font-size: ${fontSize}; line-height: 1.2; text-transform: uppercase;">${el.innerHTML}</${tagName}>`;
        } else {
            // Check for nested lists inside regular paragraphs
            if (el.querySelector('ul')) {
                let includeItemsHtml = '';
                const items = el.querySelectorAll('ul li');
                items.forEach(li => {
                    const liText = li.textContent.trim();
                    if (!liText) return;
                    const isExclude = /fee|expense|dirham|private|exclude|not\s+included|visa|tax|flight|own/i.test(liText);
                    const iconClass = isExclude ? 'fas fa-times' : 'fas fa-check';
                    const colorClass = isExclude ? 'text-danger' : 'text-success';
                    includeItemsHtml += `
                        <li style="margin-bottom: 12px; width: 50%; display: flex; align-items: center; gap: 8px;">
                            <i class="${iconClass} ${colorClass}" style="font-size: 13px; min-width: 15px;"></i>
                            <span>${liText}</span>
                        </li>`;
                });

                resultHtml += `
                    <article class="package-include bg-light-grey" style="padding: 30px 40px; margin: 25px 0; background: #f8f9fa; border-radius: 25px;">
                        <ul style="display: flex; flex-wrap: wrap; list-style: none; padding-left: 0; margin-bottom: 0; width: 100%;">
                            ${includeItemsHtml}
                        </ul>
                    </article>
                `;
            } else if (el.querySelector('ol')) {
                let itineraryItemsHtml = '';
                const items = el.querySelectorAll('ol li');
                items.forEach(li => {
                    itineraryItemsHtml += formatItineraryItem(li.innerHTML, itineraryIndex++);
                });

                resultHtml += `
                    <article class="package-ininerary" style="margin: 25px 0;">
                        <ul style="list-style: none; padding-left: 0; margin-bottom: 0;">
                            ${itineraryItemsHtml}
                        </ul>
                    </article>
                `;
            } else {
                // Keep the exact HTML tag & text
                resultHtml += el.outerHTML;
            }
        }
    });

    return resultHtml || html;
}

function formatItineraryItem(htmlContent, index) {
    const tempDiv = document.createElement('div');
    tempDiv.innerHTML = htmlContent;

    let headerText = '';
    let detailsHtml = '';

    // 1. Check for bold/strong elements which usually represent the heading
    const strongEl = tempDiv.querySelector('strong, b');
    if (strongEl) {
        headerText = strongEl.textContent.trim();
        strongEl.remove();
        detailsHtml = tempDiv.innerHTML.trim();
    } else {
        // 2. Otherwise split by first line break to separate heading from detail description
        const parts = htmlContent.split(/<br\s*\/?>/i);
        if (parts.length > 1) {
            const tempHeader = document.createElement('div');
            tempHeader.innerHTML = parts[0];
            headerText = tempHeader.textContent.trim();
            detailsHtml = parts.slice(1).join('<br>').trim();
        } else {
            // 3. Fallback: use whole text as header
            headerText = tempDiv.textContent.trim();
            detailsHtml = '';
        }
    }

    if (!headerText) return '';

    // Clean up any leading/trailing breaks in details
    detailsHtml = detailsHtml.replace(/^(<br\s*\/?>|\s)+/i, '').replace(/(<br\s*\/?>|\s)+$/i, '').trim();

    return `
        <li style="margin-bottom: 18px; display: flex; align-items: flex-start; gap: 12px;">
            <i aria-hidden="true" class="fas fa-dot-circle" style="color: #3A78C9; margin-top: 6px; font-size: 13px;"></i>
            <div>
                <span style="font-weight: 700; color: #3A78C9; display: block; margin-bottom: 4px;">${headerText}</span>
                ${detailsHtml ? `<span style="font-weight: 500; color: #626672; display: block;">${detailsHtml}</span>` : ''}
            </div>
        </li>
    `;
}

// Update header navigation elements dynamically based on user session status
function updateNavigationHeader() {
    const navUl = document.querySelector('#navigation ul');
    const navContainer = document.querySelector('.navigation-container');
    const headerBtn = document.querySelector('.header-btn a');
    const path = window.location.pathname;

    // Check if on login or register page
    if (path.endsWith('login.html') || path.endsWith('register.html')) {
        if (navContainer) {
            navContainer.style.setProperty('display', 'none', 'important');
        }
        if (headerBtn) {
            headerBtn.style.setProperty('display', 'none', 'important');
        }
        return;
    } else {
        // Reset display settings for other pages
        if (navContainer) {
            navContainer.style.display = '';
        }
        if (headerBtn) {
            headerBtn.style.display = '';
        }
    }

    if (!navUl) return;

    // Check if auth.js is loaded
    if (typeof isAuthenticated === 'undefined') return;

    // Ensure 'My Trips' link is always present in the navbar for all users
    let myTripsLi = Array.from(navUl.children).find(li => li.textContent.trim().toLowerCase().includes('my trips'));
    if (!myTripsLi) {
        myTripsLi = document.createElement('li');
        myTripsLi.innerHTML = '<a href="destination.html">My Trips</a>';
        // Insert before Gallery or at the end of default links
        const galleryLi = Array.from(navUl.children).find(li => li.textContent.trim().toLowerCase().includes('gallery'));
        if (galleryLi) {
            navUl.insertBefore(myTripsLi, galleryLi);
        } else {
            navUl.appendChild(myTripsLi);
        }
    }

    if (isAuthenticated()) {
        if (headerBtn) {
            headerBtn.textContent = 'Book Now';
            headerBtn.href = 'booking.html';
        }

        // Add Logout button if not already present
        let logoutLi = Array.from(navUl.children).find(li => li.textContent.trim().toLowerCase().includes('logout'));
        if (!logoutLi) {
            logoutLi = document.createElement('li');
            logoutLi.innerHTML = '<a href="#" id="auth-logout-btn" style="color: #d9383a; font-weight: bold;">Logout</a>';
            navUl.appendChild(logoutLi);

            document.getElementById('auth-logout-btn').addEventListener('click', (e) => {
                e.preventDefault();
                logoutUser();
            });
        }

        // Remove Login link if present
        const loginLi = Array.from(navUl.children).find(li => li.textContent.trim().toLowerCase().includes('login'));
        if (loginLi) {
            loginLi.remove();
        }
    } else {
        if (headerBtn) {
            headerBtn.textContent = 'Login';
            headerBtn.href = 'login.html';
        }

        // Guest user: hide Logout and remove Login link from navbar list
        const logoutLi = Array.from(navUl.children).find(li => li.textContent.trim().toLowerCase().includes('logout'));
        if (logoutLi) {
            logoutLi.remove();
        }

        const loginLi = Array.from(navUl.children).find(li => li.textContent.trim().toLowerCase().includes('login'));
        if (loginLi) {
            loginLi.remove();
        }
    }
}

