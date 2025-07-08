@extends('layouts.app')

@section('title', $destination->name . ' - ' . $destination->location)

@section('content')
    <!-- Destination Hero -->
    <section class="relative pt-24 pb-24 text-white">
        <div class="absolute inset-0 bg-cover bg-center"
            style="background-image: url('{{ filter_var($destination->main_image, FILTER_VALIDATE_URL) ? $destination->main_image : asset($destination->main_image) }}');">
            @if (count($destination->gallery) > 0)
                <div class="absolute inset-0 bg-cover bg-center"
                    style="background-image: url('{{ filter_var($destination->gallery[0], FILTER_VALIDATE_URL) ? $destination->gallery[0] : asset($destination->gallery[0]) }}');">
                </div>
            @endif
            <!-- Dynamic overlay using CSS variables -->
            <div class="absolute inset-0 bg-gradient-to-t from-teal-500/90 to-primary-600/30 " style="opacity: 0.6"></div>
        </div>
        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-3xl md:text-5xl font-bold mb-2 drop-shadow-lg">{{ $destination->name }}</h1>
                <p class="text-xl opacity-90 mb-6 drop-shadow-md">{{ $destination->location }}</p>

                <div class="inline-block px-6 py-2 bg-yellow-500 rounded-full text-white font-semibold shadow-lg">
                    @if ($destination->bundle)
                        Part of {{ $destination->bundle->name }} Bundle
                    @else
                        Featured Destination
                    @endif
                </div>
            </div>
        </div>

        <!-- Wave Divider -->
        <div class="absolute bottom-0 left-0 right-0 w-full" style="z-index: 1;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 120" preserveAspectRatio="none"
                style="width: 100%; height: 120px; display: block;">
                <path fill="#ffffff" fill-opacity="1"
                    d="M0,64L80,69.3C160,75,320,85,480,80C640,75,800,53,960,48C1120,43,1280,53,1360,58.7L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z">
                </path>
            </svg>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row gap-10">
                <!-- Left Column - Main Content -->
                <div class="lg:w-2/3">
                    <!-- Main Image -->
                    <div class="mb-8 rounded-2xl overflow-hidden shadow-lg h-96">
                        <img src="{{ filter_var($destination->main_image, FILTER_VALIDATE_URL) ? $destination->main_image : asset($destination->main_image) }}"
                            alt="{{ $destination->name }}" class="w-full h-full object-cover">
                    </div>

                    <!-- Description -->
                    <div class="bg-white rounded-2xl shadow-md p-8 mb-8">
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">About {{ $destination->name }}</h2>
                        <div class="prose max-w-none text-gray-600">
                            {{ $destination->description }}
                        </div>
                    </div>

                    <!-- Gallery -->
                    @if (count($destination->gallery) > 0)
                        <div class="bg-white rounded-2xl shadow-md p-8 mb-8">
                            <h2 class="text-2xl font-bold text-gray-800 mb-6">Gallery</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach ($destination->gallery as $image)
                                    <div class="aspect-w-4 aspect-h-3 rounded-lg overflow-hidden">
                                        <img src="{{ filter_var($image, FILTER_VALIDATE_URL) ? $image : asset($image) }}"
                                            alt="{{ $destination->name }} gallery image"
                                            class="w-full h-full object-cover transition-transform duration-300 hover:scale-110">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Restrictions -->
                    @if ($destination->restrictions)
                        <div class="bg-white rounded-2xl shadow-md p-8 mb-8">
                            <h2 class="text-2xl font-bold text-gray-800 mb-4">Restrictions & Important Information</h2>
                            <div class="prose max-w-none text-gray-600">
                                {{ $destination->restrictions }}
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right Column - Sidebar -->
                <div class="lg:w-1/3">
                    <!-- What's Included -->
                    <div class="bg-white rounded-2xl shadow-md p-8 mb-8">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">What's Included</h2>
                        <ul class="space-y-4">
                            @foreach ($destination->included_items as $item)
                                <li class="flex items-start">
                                    <svg class="h-6 w-6 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-gray-700">{{ $item }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Bundle Information (if part of a bundle) -->
                    @if ($destination->bundle)
                        <div
                            class="bg-gradient-to-r from-primary-50 to-indigo-50 rounded-2xl shadow-md p-8 mb-8 relative overflow-hidden bundle-shine">
                            <div class="relative z-10">
                                <h2 class="text-2xl font-bold text-primary-800 mb-2">Part of a Bundle</h2>
                                <p class="text-gray-700 mb-4">This destination is part of our
                                    {{ $destination->bundle->name }} package.</p>

                                <div class="bg-white p-4 rounded-lg mb-4 shadow-sm">
                                    <div class="text-sm text-gray-500">Starting at</div>
                                    <div class="text-3xl font-bold text-primary-700">${{ $destination->bundle->price }}
                                    </div>
                                    <div class="text-sm text-gray-500">per person</div>
                                </div>
                                <a href="{{ route('bundles.show', $destination->bundle->slug) }}"
                                    class="block w-full text-center py-3 bg-gradient-to-r from-teal-500 to-indigo-700 text-white rounded-full font-semibold hover:from-primary-700 hover:to-indigo-800 transition-colors shadow-lg">
                                    VIEW BUNDLE DETAILS
                                </a>
                            </div>
                        </div>
                    @endif

                    <!-- Contact Form -->
                    <div class="bg-white rounded-2xl shadow-md p-8">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">Inquire About This Destination</h2>
                        <form action="#" method="POST">
                            @csrf
                            <input type="hidden" name="destination_id" value="{{ $destination->id }}">
                            <div class="mb-4">
                                <label for="name" class="block text-gray-700 font-medium mb-2">Your Name</label>
                                <input type="text" id="name" name="name"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500">
                            </div>

                            <div class="mb-4">
                                <label for="email" class="block text-gray-700 font-medium mb-2">Email Address</label>
                                <input type="email" id="email" name="email"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500">
                            </div>

                            <div class="mb-4">
                                <label for="phone" class="block text-gray-700 font-medium mb-2">Phone Number</label>
                                <input type="tel" id="phone" name="phone"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500">
                            </div>

                            <div class="mb-6">
                                <label for="message" class="block text-gray-700 font-medium mb-2">Your Message</label>
                                <textarea id="message" name="message" rows="4"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500"></textarea>
                            </div>
                            <button type="submit"
                                class="w-full py-3 bg-gradient-to-r from-teal-600 to-indigo-700 text-white rounded-full font-semibold hover:from-primary-700 hover:to-indigo-800 transition-colors shadow-lg">
                                SEND INQUIRY
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Hotels Section -->
    @if ($destination->hotels && $destination->hotels->count() > 0)
        <section class="py-16 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-primary-800 mb-4">
                        <span class="relative inline-block">
                            WHERE TO STAY IN {{ strtoupper($destination->name) }}
                            <span class="absolute bottom-0 left-0 w-full h-1 bg-yellow-400"></span>
                        </span>
                    </h2>
                    <p class="text-gray-600 max-w-2xl mx-auto">
                        Discover handpicked accommodations that offer comfort, luxury, and authentic experiences in
                        {{ $destination->name }}
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($destination->hotels->sortBy('price') as $hotel)
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 hotel-card cursor-pointer"
                            data-hotel-id="{{ $hotel->id }}">
                            <!-- Hotel Image -->
                            <div class="relative h-64">
                                @if ($hotel->photos && count($hotel->photos) > 0)
                                    <img src="{{ filter_var($hotel->photos[0], FILTER_VALIDATE_URL) ? $hotel->photos[0] : asset('storage/' . $hotel->photos[0]) }}"
                                        alt="{{ $hotel->name }}"
                                        class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                                @else
                                    <div
                                        class="w-full h-full bg-gradient-to-br from-gray-300 to-gray-400 flex items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                            </path>
                                        </svg>
                                    </div>
                                @endif

                                @if ($hotel->price)
                                    <div
                                        class="absolute top-4 right-4 bg-primary-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                        Starting from ${{ number_format($hotel->price, 0) }}
                                    </div>
                                @endif
                            </div>

                            <!-- Hotel Content -->
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $hotel->name }}</h3>

                                @if ($hotel->address)
                                    <div class="flex items-start text-gray-600 mb-4">
                                        <svg class="w-4 h-4 mt-1 mr-2 flex-shrink-0" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <span
                                            class="text-sm">{{ \Illuminate\Support\Str::limit($hotel->address, 50) }}</span>
                                    </div>
                                @endif

                                <!-- Amenities -->
                                @if ($hotel->amenities && count($hotel->amenities) > 0)
                                    <div class="mb-4">
                                        <div class="flex flex-wrap gap-2">
                                            @foreach (array_slice($hotel->amenities, 0, 3) as $amenity)
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    {{ $amenity }}
                                                </span>
                                            @endforeach
                                            @if (count($hotel->amenities) > 3)
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    +{{ count($hotel->amenities) - 3 }} more
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                <!-- Price and CTA -->
                                <div class="flex items-center justify-between">
                                    <div>
                                        @if ($hotel->price)
                                            <p class="text-sm text-gray-500">Starting as low as</p>
                                            <p class="text-2xl font-bold text-primary-600">
                                                ${{ number_format($hotel->price, 0) }}</p>
                                            <p class="text-sm text-gray-500">per night</p>
                                        @else
                                            <p class="text-lg font-semibold text-gray-600">Contact for pricing</p>
                                        @endif
                                    </div>
                                    <button
                                        class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 view-hotel-btn">
                                        View Details
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- View All Hotels Button -->
                @if ($destination->hotels->count() > 6)
                    <div class="text-center mt-12">
                        <button
                            class="inline-flex items-center px-6 py-3 bg-white border-2 border-primary-600 text-primary-600 font-semibold rounded-lg hover:bg-primary-600 hover:text-white transition-colors duration-300"
                            id="load-more-hotels">
                            View All Hotels in {{ $destination->name }}
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </button>
                    </div>
                @endif
            </div>
        </section>
    @endif

    <!-- Hotel Modal -->
    <div id="hotel-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div
            class="relative top-5 mx-auto p-0 border w-11/12 md:w-4/5 lg:w-3/4 xl:w-2/3 shadow-lg rounded-2xl bg-white max-h-[95vh] overflow-hidden">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b bg-white z-10 rounded-t-2xl relative">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900" id="modal-hotel-name">Hotel Name</h3>
                    <p class="text-gray-600" id="modal-hotel-location">Location</p>
                </div>
                <button class="text-gray-400 hover:text-gray-600 p-2 rounded-full hover:bg-gray-100 transition-colors"
                    id="close-modal">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Content -->
            <div class="overflow-y-auto max-h-[calc(95vh-120px)]" id="modal-content">
                <!-- Loading spinner -->
                <div class="text-center py-16" id="modal-loading">
                    <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-primary-600"></div>
                    <p class="mt-4 text-gray-600 text-lg">Loading hotel details...</p>
                </div>
            </div>
        </div>
    </div>

    <x-testimonials :testimonials="$testimonials" />

    <!-- Related Destinations (if applicable) -->
    @if ($destination->bundle && $destination->bundle->destinations->count() > 1)
        <section class="py-16">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-bold text-primary-800 mb-12 text-center">
                    <span class="relative inline-block">
                        OTHER DESTINATIONS IN THIS BUNDLE
                        <span class="absolute bottom-0 left-0 w-full h-1 bg-yellow-400"></span>
                    </span>
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($destination->bundle->destinations as $relatedDestination)
                        @if ($relatedDestination->id != $destination->id)
                            <!-- Destination Card -->
                            <div class="destination-card bg-white rounded-2xl shadow-lg overflow-hidden">
                                <div class="relative h-64">
                                    <img src="{{ filter_var($relatedDestination->main_image, FILTER_VALIDATE_URL) ? $relatedDestination->main_image : asset($relatedDestination->main_image) }}"
                                        alt="{{ $relatedDestination->name }}" class="w-full h-full object-cover">
                                    <div
                                        class="absolute top-0 left-0 page-title-bg text-white px-4 py-2 rounded-br-lg font-medium">
                                        {{ $relatedDestination->name }}, {{ $relatedDestination->location }}
                                    </div>
                                    <div class="absolute bottom-0 left-0 w-full">
                                        <div class="bg-gradient-to-t from-black to-transparent text-white p-4">
                                            <div class="font-semibold text-lg">{{ $relatedDestination->name }}</div>
                                            <div class="text-sm">{{ $relatedDestination->location }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-6">
                                    <p class="text-gray-600 mb-6 line-clamp-3">
                                        {{ \Illuminate\Support\Str::limit($relatedDestination->description, 100) }}</p>
                                    <a href="{{ route('destinations.show', $relatedDestination->id) }}"
                                        class="block w-full text-center py-3 bg-gradient-to-r from-primary-600 to-indigo-700 text-white rounded-full font-semibold hover:from-primary-700 hover:to-indigo-800 transition-colors shadow-lg">
                                        VIEW DETAILS
                                    </a>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('hotel-modal');
            const closeModal = document.getElementById('close-modal');
            const modalContent = document.getElementById('modal-content');
            const modalTitle = document.getElementById('modal-hotel-name');
            const modalLocation = document.getElementById('modal-hotel-location');
            const modalLoading = document.getElementById('modal-loading');

            // Check if required elements exist
            if (!modal || !closeModal || !modalContent || !modalTitle || !modalLocation || !modalLoading) {
                console.error('Modal elements not found');
                return;
            }

            // View hotel details
            document.querySelectorAll('.hotel-card').forEach(card => {
                card.addEventListener('click', function(e) {
                    // Prevent triggering if clicking on buttons inside the card
                    if (e.target.closest('button')) {
                        return;
                    }
                    const hotelId = this.getAttribute('data-hotel-id');
                    if (hotelId) {
                        loadHotelDetails(hotelId);
                    }
                });
            });

            // Close modal
            closeModal.addEventListener('click', function() {
                closeModalFunction();
            });

            // Close modal when clicking outside
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeModalFunction();
                }
            });

            // Escape key to close modal
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                    closeModalFunction();
                }
            });

            function closeModalFunction() {
                modal.classList.add('hidden');
                // Clean up any existing details
                const existingDetails = modalContent.querySelector('#hotel-details');
                if (existingDetails) {
                    existingDetails.remove();
                }
                // Reset loading state
                modalLoading.style.display = 'none';
            }

            function loadHotelDetails(hotelId) {
                // Show modal and loading state
                modal.classList.remove('hidden');
                modalLoading.style.display = 'block';

                // Clean up previous content
                const existingDetails = modalContent.querySelector('#hotel-details');
                if (existingDetails) {
                    existingDetails.remove();
                }

                // Reset modal content
                modalTitle.textContent = 'Loading...';
                modalLocation.textContent = '';

                // Fetch hotel details
                fetch(`/api/hotels/${hotelId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Handle both response formats (with or without .data wrapper)
                        const hotel = data.data || data;

                        modalTitle.textContent = hotel.name || 'Hotel';
                        modalLocation.textContent = hotel.destination ?
                            `${hotel.destination.name}, ${hotel.destination.location}` : '';
                        modalLoading.style.display = 'none';

                        // Build comprehensive hotel details
                        let heroImageHtml = '';
                        if (hotel.photo_urls && hotel.photo_urls.length > 0) {
                            heroImageHtml = `
                                <div class="relative h-64 md:h-80 mb-6">
                                    <img src="${hotel.photo_urls[0]}" alt="${hotel.name}"
                                         class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                                    ${hotel.price ? `
                                            <div class="absolute bottom-4 right-4 bg-white/95 backdrop-blur-sm px-4 py-2 rounded-full">
                                                <span class="text-primary-600 font-bold text-lg">From $${parseFloat(hotel.price).toLocaleString()}/night</span>
                                            </div>
                                        ` : ''}
                                </div>
                            `;
                        }

                        let addressHtml = '';
                        if (hotel.address) {
                            addressHtml = `
                                <div class="flex items-start mb-6 p-4 bg-gray-50 rounded-lg">
                                    <svg class="w-5 h-5 text-primary-600 mr-3 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <div>
                                        <h4 class="font-semibold text-gray-900 mb-1">Address</h4>
                                        <p class="text-gray-600">${hotel.address}</p>
                                        ${hotel.destination ? `<p class="text-sm text-gray-500 mt-1">${hotel.destination.name}, ${hotel.destination.location}</p>` : ''}
                                    </div>
                                </div>
                            `;
                        }

                        let pricingHtml = '';
                        if (hotel.price) {
                            pricingHtml = `
                                <div class="bg-gradient-to-r from-primary-50 to-indigo-50 p-6 rounded-xl mb-6">
                                    <div class="text-center">
                                        <h4 class="text-lg font-semibold text-gray-900 mb-2">Pricing</h4>
                                        <div class="flex items-center justify-center space-x-2 mb-2">
                                            <span class="text-sm text-gray-600">Starting as low as</span>
                                        </div>
                                        <div class="text-4xl font-bold text-primary-600 mb-1">$${parseFloat(hotel.price).toLocaleString()}</div>
                                        <div class="text-sm text-gray-600">per night</div>
                                        <div class="mt-3 text-xs text-gray-500">
                                            * Prices may vary based on season, availability, and booking dates
                                        </div>
                                    </div>
                                </div>
                            `;
                        } else {
                            pricingHtml = `
                                <div class="bg-gray-50 p-6 rounded-xl mb-6 text-center">
                                    <h4 class="text-lg font-semibold text-gray-900 mb-2">Custom Pricing</h4>
                                    <p class="text-gray-600 mb-2">Contact us for the best rates and availability</p>
                                    <div class="text-sm text-gray-500">We'll provide personalized pricing based on your travel dates and requirements</div>
                                </div>
                            `;
                        }

                        let amenitiesHtml = '';
                        if (hotel.amenities && Array.isArray(hotel.amenities) && hotel.amenities.length > 0) {
                            // Group amenities by type
                            const amenityGroups = {
                                'Room Features': [],
                                'Hotel Services': [],
                                'Recreation': [],
                                'Other': []
                            };

                            hotel.amenities.forEach(amenity => {
                                const lower = amenity.toLowerCase();
                                if (lower.includes('wifi') || lower.includes('tv') || lower.includes(
                                        'ac') ||
                                    lower.includes('conditioning') || lower.includes('room') || lower
                                    .includes('bed') ||
                                    lower.includes('bathroom')) {
                                    amenityGroups['Room Features'].push(amenity);
                                } else if (lower.includes('service') || lower.includes('desk') || lower
                                    .includes('concierge') ||
                                    lower.includes('reception') || lower.includes('breakfast') || lower
                                    .includes('restaurant')) {
                                    amenityGroups['Hotel Services'].push(amenity);
                                } else if (lower.includes('pool') || lower.includes('gym') || lower
                                    .includes('spa') ||
                                    lower.includes('fitness') || lower.includes('beach') || lower
                                    .includes('bar')) {
                                    amenityGroups['Recreation'].push(amenity);
                                } else {
                                    amenityGroups['Other'].push(amenity);
                                }
                            });

                            let amenityGroupsHtml = '';
                            Object.entries(amenityGroups).forEach(([group, amenities]) => {
                                if (amenities.length > 0) {
                                    amenityGroupsHtml += `
                                        <div class="mb-4">
                                            <h5 class="font-semibold text-gray-800 mb-2">${group}</h5>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                                ${amenities.map(amenity => `
                                                        <div class="flex items-center">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-500 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                            </svg>
                                                            <span class="text-sm text-gray-700">${amenity}</span>
                                                        </div>
                                                    `).join('')}
                                            </div>
                                        </div>
                                    `;
                                }
                            });

                            amenitiesHtml = `
                                <div class="mb-6">
                                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Amenities & Features</h4>
                                    <div class="bg-white border border-gray-200 rounded-lg p-4">
                                        ${amenityGroupsHtml}
                                    </div>
                                </div>
                            `;
                        }

                        let photosHtml = '';
                        if (hotel.photo_urls && Array.isArray(hotel.photo_urls) && hotel.photo_urls.length >
                            1) {
                            photosHtml = `
                                <div class="mb-6">
                                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Hotel Gallery (${hotel.photo_urls.length} Photos)</h4>
                                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                                        ${hotel.photo_urls.map((photo, index) => `
                                                <div class="relative aspect-w-4 aspect-h-3 rounded-lg overflow-hidden cursor-pointer hover:opacity-75 transition-opacity group" data-photo-index="${index}">
                                                    <img src="${photo}" alt="${hotel.name} - Photo ${index + 1}"
                                                         class="w-full h-24 object-cover rounded-lg group-hover:scale-105 transition-transform duration-300">
                                                    <div class="absolute inset-0 bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300 flex items-center justify-center">
                                                        <svg class="w-6 h-6 text-white opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                                                        </svg>
                                                    </div>
                                                </div>
                                            `).join('')}
                                    </div>
                                    <p class="text-sm text-gray-500 mt-2">Click on any image to view in full size</p>
                                </div>
                            `;
                        }

                        let seoHtml = '';
                        if (hotel.seo_description) {
                            seoHtml = `
                                <div class="mb-6">
                                    <h4 class="text-lg font-semibold text-gray-900 mb-3">About This Hotel</h4>
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <p class="text-gray-700 leading-relaxed">${hotel.seo_description}</p>
                                    </div>
                                </div>
                            `;
                        }

                        const detailsHtml = `
                            <div id="hotel-details" class="p-6">
                                ${heroImageHtml}

                                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                                    <!-- Main Content -->
                                    <div class="lg:col-span-2">
                                        ${addressHtml}
                                        ${seoHtml}
                                        ${amenitiesHtml}
                                        ${photosHtml}
                                    </div>

                                    <!-- Sidebar -->
                                    <div class="lg:col-span-1">
                                        ${pricingHtml}

                                        <!-- Action Buttons -->
                                        <div class="space-y-3 mb-6">
                                            <button class="w-full bg-gradient-to-r from-primary-600 to-indigo-700 hover:from-primary-700 hover:to-indigo-800 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 shadow-md hover:shadow-lg book-hotel-btn">
                                                Book This Hotel
                                            </button>
                                            <button class="w-full bg-white border-2 border-primary-600 text-primary-600 hover:bg-primary-600 hover:text-white px-6 py-3 rounded-lg font-semibold transition-colors duration-300 contact-hotel-btn">
                                                Contact Hotel
                                            </button>
                                            <button class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-medium transition-colors duration-300 text-sm wishlist-btn">
                                                Add to Wishlist
                                            </button>
                                        </div>

                                        <!-- Quick Info -->
                                        <div class="bg-white border border-gray-200 rounded-lg p-4">
                                            <h5 class="font-semibold text-gray-900 mb-3">Quick Information</h5>
                                            <div class="space-y-2 text-sm">
                                                ${hotel.destination ? `
                                                        <div class="flex justify-between">
                                                            <span class="text-gray-600">Location:</span>
                                                            <span class="text-gray-900">${hotel.destination.name}</span>
                                                        </div>
                                                    ` : ''}
                                                <div class="flex justify-between">
                                                    <span class="text-gray-600">Photos:</span>
                                                    <span class="text-gray-900">${hotel.photo_urls ? hotel.photo_urls.length : 0} available</span>
                                                </div>
                                                <div class="flex justify-between">
                                                    <span class="text-gray-600">Amenities:</span>
                                                    <span class="text-gray-900">${hotel.amenities ? hotel.amenities.length : 0} features</span>
                                                </div>
                                                ${hotel.price ? `
                                                        <div class="flex justify-between">
                                                            <span class="text-gray-600">Starting Rate:</span>
                                                            <span class="text-green-600 font-semibold">$${parseFloat(hotel.price).toLocaleString()}/night</span>
                                                        </div>
                                                    ` : ''}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;

                        modalContent.insertAdjacentHTML('beforeend', detailsHtml);

                        // Add photo gallery click handlers
                        setTimeout(() => {
                            document.querySelectorAll('[data-photo-index]').forEach(photoEl => {
                                photoEl.addEventListener('click', function() {
                                    const photoIndex = parseInt(this.getAttribute(
                                        'data-photo-index'));
                                    if (hotel.photo_urls && hotel.photo_urls.length >
                                        photoIndex) {
                                        openPhotoGallery(hotel.photo_urls, photoIndex,
                                            hotel.name);
                                    }
                                });
                            });
                        }, 100);
                    })
                    .catch(error => {
                        console.error('Error fetching hotel details:', error);
                        modalLoading.style.display = 'none';
                        modalTitle.textContent = 'Error';
                        modalLocation.textContent = '';

                        const errorHtml = `
                            <div id="hotel-details" class="text-center py-8 px-6">
                                <div class="text-red-500 mb-4">
                                    <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Unable to Load Hotel Details</h3>
                                <p class="text-gray-600 mb-4">We're having trouble loading the hotel information. Please try again.</p>
                                <button class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 retry-btn" data-hotel-id="${hotelId}">
                                    Try Again
                                </button>
                            </div>
                        `;

                        modalContent.insertAdjacentHTML('beforeend', errorHtml);

                        // Add retry functionality
                        const retryBtn = modalContent.querySelector('.retry-btn');
                        if (retryBtn) {
                            retryBtn.addEventListener('click', function() {
                                const hotelId = this.getAttribute('data-hotel-id');
                                loadHotelDetails(hotelId);
                            });
                        }
                    });
            }

            // Image gallery lightbox functionality
            window.openPhotoGallery = function(photos, startIndex = 0, hotelName = '') {
                if (!photos || !Array.isArray(photos) || photos.length === 0) {
                    console.error('Invalid photos array');
                    return;
                }

                const lightbox = document.createElement('div');
                lightbox.className =
                    'fixed inset-0 bg-black bg-opacity-90 flex items-center justify-center z-[60] p-4';
                lightbox.innerHTML = `
                    <div class="relative max-w-6xl max-h-full w-full">
                        <!-- Gallery Header -->
                        <div class="absolute top-4 left-4 right-4 flex justify-between items-center z-10">
                            <div class="text-white">
                                <h3 class="text-lg font-semibold">${hotelName || 'Hotel Gallery'}</h3>
                                <p class="text-sm opacity-75">Photo <span id="current-photo">${startIndex + 1}</span> of ${photos.length}</p>
                            </div>
                            <button class="text-white hover:text-gray-300 p-2 rounded-full hover:bg-white/10 transition-colors close-lightbox">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <!-- Main Image -->
                        <div class="flex items-center justify-center h-full">
                            ${photos.length > 1 ? `
                                    <button class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white hover:text-gray-300 p-3 rounded-full hover:bg-white/10 transition-colors prev-photo">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                        </svg>
                                    </button>
                                ` : ''}

                            <img id="gallery-main-image" src="${photos[startIndex]}" alt="${hotelName}"
                                 class="max-w-full max-h-full object-contain rounded-lg shadow-2xl">

                            ${photos.length > 1 ? `
                                    <button class="absolute right-4 top-1/2 transform -translate-y-1/2 text-white hover:text-gray-300 p-3 rounded-full hover:bg-white/10 transition-colors next-photo">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </button>
                                ` : ''}
                        </div>

                        <!-- Thumbnail Strip -->
                        ${photos.length > 1 ? `
                                <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 max-w-full overflow-x-auto">
                                    <div class="flex space-x-2 px-4">
                                        ${photos.map((photo, index) => `
                                        <img src="${photo}" alt="Thumbnail ${index + 1}"
                                             class="w-16 h-16 object-cover rounded cursor-pointer border-2 transition-all ${index === startIndex ? 'border-white' : 'border-transparent opacity-60 hover:opacity-80'}"
                                             data-index="${index}">
                                    `).join('')}
                                    </div>
                                </div>
                            ` : ''}
                    </div>
                `;

                document.body.appendChild(lightbox);

                let currentIndex = startIndex;
                const mainImage = lightbox.querySelector('#gallery-main-image');
                const currentPhotoSpan = lightbox.querySelector('#current-photo');
                const thumbnails = lightbox.querySelectorAll('[data-index]');

                function updateGallery(newIndex) {
                    if (newIndex < 0 || newIndex >= photos.length) return;

                    currentIndex = newIndex;
                    mainImage.src = photos[currentIndex];
                    if (currentPhotoSpan) {
                        currentPhotoSpan.textContent = currentIndex + 1;
                    }

                    // Update thumbnail borders
                    thumbnails.forEach((thumb, index) => {
                        if (index === currentIndex) {
                            thumb.classList.remove('border-transparent', 'opacity-60');
                            thumb.classList.add('border-white');
                        } else {
                            thumb.classList.remove('border-white');
                            thumb.classList.add('border-transparent', 'opacity-60');
                        }
                    });
                }

                // Navigation event listeners
                const prevBtn = lightbox.querySelector('.prev-photo');
                const nextBtn = lightbox.querySelector('.next-photo');
                const closeBtn = lightbox.querySelector('.close-lightbox');

                if (prevBtn) {
                    prevBtn.addEventListener('click', () => {
                        const newIndex = currentIndex > 0 ? currentIndex - 1 : photos.length - 1;
                        updateGallery(newIndex);
                    });
                }

                if (nextBtn) {
                    nextBtn.addEventListener('click', () => {
                        const newIndex = currentIndex < photos.length - 1 ? currentIndex + 1 : 0;
                        updateGallery(newIndex);
                    });
                }

                if (closeBtn) {
                    closeBtn.addEventListener('click', () => {
                        lightbox.remove();
                    });
                }

                // Thumbnail clicks
                thumbnails.forEach((thumb, index) => {
                    thumb.addEventListener('click', () => updateGallery(index));
                });

                // Keyboard navigation
                const handleKeyPress = (e) => {
                    if (e.key === 'ArrowLeft' && photos.length > 1) {
                        const newIndex = currentIndex > 0 ? currentIndex - 1 : photos.length - 1;
                        updateGallery(newIndex);
                    } else if (e.key === 'ArrowRight' && photos.length > 1) {
                        const newIndex = currentIndex < photos.length - 1 ? currentIndex + 1 : 0;
                        updateGallery(newIndex);
                    } else if (e.key === 'Escape') {
                        lightbox.remove();
                    }
                };

                document.addEventListener('keydown', handleKeyPress);

                // Close lightbox on click outside image
                lightbox.addEventListener('click', function(e) {
                    if (e.target === lightbox) {
                        lightbox.remove();
                    }
                });

                // Cleanup when lightbox is removed
                const observer = new MutationObserver(function(mutations) {
                    mutations.forEach(function(mutation) {
                        if (mutation.type === 'childList') {
                            mutation.removedNodes.forEach(function(node) {
                                if (node === lightbox) {
                                    document.removeEventListener('keydown',
                                        handleKeyPress);
                                    observer.disconnect();
                                }
                            });
                        }
                    });
                });
                observer.observe(document.body, {
                    childList: true
                });
            };

            // Enhanced modal interactions
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('book-hotel-btn')) {
                    alert(
                        'Booking functionality would be implemented here. This could redirect to a booking form or open another modal.');
                }

                if (e.target.classList.contains('contact-hotel-btn')) {
                    alert(
                        'Contact functionality would be implemented here. This could open a contact form or show contact details.');
                }

                if (e.target.classList.contains('wishlist-btn')) {
                    e.target.textContent = 'Added to Wishlist';
                    e.target.classList.remove('bg-gray-100', 'hover:bg-gray-200', 'text-gray-700');
                    e.target.classList.add('bg-green-100', 'text-green-700');
                    setTimeout(() => {
                        e.target.textContent = 'Add to Wishlist';
                        e.target.classList.remove('bg-green-100', 'text-green-700');
                        e.target.classList.add('bg-gray-100', 'hover:bg-gray-200', 'text-gray-700');
                    }, 2000);
                }
            });

            // Load more hotels functionality
            const loadMoreBtn = document.getElementById('load-more-hotels');
            if (loadMoreBtn) {
                loadMoreBtn.addEventListener('click', function() {
                    const hiddenHotels = document.querySelectorAll('.hotel-card.hidden');
                    if (hiddenHotels.length > 0) {
                        hiddenHotels.forEach(hotel => hotel.classList.remove('hidden'));
                        this.style.display = 'none';
                    } else {
                        alert('All hotels are already displayed');
                    }
                });
            }
        });
    </script>
@endsection
