@extends('layouts.app')

@section('title', $hotel->name . ' - ' . ($hotel->destination->name ?? 'Hotel'))

@section('content')
    <!-- Hotel Hero Section -->
    <section class="relative pt-24 pb-24 text-white">
        <div class="absolute inset-0 bg-cover bg-center"
            style="background-image: url('{{ $hotel->photos && count($hotel->photos) > 0 ? (filter_var($hotel->photos[0], FILTER_VALIDATE_URL) ? $hotel->photos[0] : asset($hotel->photos[0])) : asset('images/default-hotel.jpg') }}');">
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-black/30"></div>
        </div>
        
        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-4xl mx-auto">
                <!-- Breadcrumb -->
                <nav class="mb-6">
                    <ol class="flex items-center space-x-2 text-sm">
                        <li><a href="{{ route('home') }}" class="text-white/80 hover:text-white">Home</a></li>
                        <li><span class="text-white/60">/</span></li>
                        @if($hotel->destination)
                            <li><a href="{{ route('destinations.show', $hotel->destination->id) }}" class="text-white/80 hover:text-white">{{ $hotel->destination->name }}</a></li>
                            <li><span class="text-white/60">/</span></li>
                        @endif
                        <li><span class="text-white">{{ $hotel->name }}</span></li>
                    </ol>
                </nav>

                <div class="text-center">
                    <h1 class="text-4xl md:text-6xl font-bold mb-4 drop-shadow-lg">{{ $hotel->name }}</h1>
                    @if($hotel->destination)
                        <p class="text-xl opacity-90 mb-4 drop-shadow-md">{{ $hotel->destination->name }}, {{ $hotel->destination->location }}</p>
                    @endif
                    @if($hotel->address)
                        <div class="flex items-center justify-center text-lg opacity-80 mb-6">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            {{ $hotel->address }}
                        </div>
                    @endif

                    <div class="inline-block px-6 py-2 bg-yellow-500 rounded-full text-white font-semibold shadow-lg">
                        Premium Accommodation
                    </div>
                </div>
            </div>
        </div>

        <!-- Wave Divider -->
        <div class="absolute bottom-0 left-0 right-0 w-full">
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
                    <!-- Photo Gallery -->
                    @if($hotel->photos && count($hotel->photos) > 0)
                        <div class="mb-8">
                            <h2 class="text-2xl font-bold text-gray-800 mb-6">Hotel Gallery</h2>
                            
                            <!-- Main Featured Image -->
                            <div class="mb-4 rounded-2xl overflow-hidden shadow-lg h-96">
                                <img id="main-image" src="{{ filter_var($hotel->photos[0], FILTER_VALIDATE_URL) ? $hotel->photos[0] : asset($hotel->photos[0]) }}"
                                    alt="{{ $hotel->name }}" class="w-full h-full object-cover">
                            </div>

                            <!-- Thumbnail Gallery -->
                            @if(count($hotel->photos) > 1)
                                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-2">
                                    @foreach($hotel->photos as $index => $photo)
                                        <div class="aspect-w-4 aspect-h-3 rounded-lg overflow-hidden cursor-pointer hover:opacity-80 transition-opacity {{ $index === 0 ? 'ring-2 ring-blue-500' : '' }}"
                                             onclick="changeMainImage('{{ filter_var($photo, FILTER_VALIDATE_URL) ? $photo : asset($photo) }}', this)">
                                            <img src="{{ filter_var($photo, FILTER_VALIDATE_URL) ? $photo : asset($photo) }}"
                                                alt="{{ $hotel->name }} photo {{ $index + 1 }}"
                                                class="w-full h-full object-cover">
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Hotel Description -->
                    <div class="bg-white rounded-2xl shadow-md p-8 mb-8">
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">About {{ $hotel->name }}</h2>
                        <div class="prose max-w-none text-gray-600">
                            @if($hotel->description)
                                {{ $hotel->description }}
                            @else
                                <p>Experience luxury and comfort at {{ $hotel->name }}, perfectly located in {{ $hotel->destination->name ?? 'a prime location' }}. Our hotel offers exceptional service and world-class amenities to ensure your stay is memorable.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Amenities -->
                    @if($hotel->amenities && count($hotel->amenities) > 0)
                        <div class="bg-white rounded-2xl shadow-md p-8 mb-8">
                            <h2 class="text-2xl font-bold text-gray-800 mb-6">Hotel Amenities</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($hotel->amenities as $amenity)
                                    <div class="flex items-center">
                                        <svg class="h-5 w-5 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span class="text-gray-700">{{ $amenity }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right Column - Sidebar -->
                <div class="lg:w-1/3">
                    <!-- Quick Info -->
                    <div class="bg-white rounded-2xl shadow-md p-8 mb-8">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">Hotel Information</h2>
                        
                        @if($hotel->destination)
                            <div class="mb-4">
                                <div class="flex items-center mb-2">
                                    <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span class="font-medium text-gray-700">Destination</span>
                                </div>
                                <p class="text-gray-600 ml-7">{{ $hotel->destination->name }}, {{ $hotel->destination->location }}</p>
                            </div>
                        @endif

                        @if($hotel->amenities)
                            <div class="mb-4">
                                <div class="flex items-center mb-2">
                                    <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                    </svg>
                                    <span class="font-medium text-gray-700">Amenities</span>
                                </div>
                                <p class="text-gray-600 ml-7">{{ count($hotel->amenities) }} premium amenities available</p>
                            </div>
                        @endif

                        @if($hotel->photos)
                            <div class="mb-4">
                                <div class="flex items-center mb-2">
                                    <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="font-medium text-gray-700">Photos</span>
                                </div>
                                <p class="text-gray-600 ml-7">{{ count($hotel->photos) }} high-quality images</p>
                            </div>
                        @endif

                        @if($hotel->destination)
                            <a href="{{ route('destinations.show', $hotel->destination->id) }}" 
                               class="block w-full text-center py-3 bg-gradient-to-r from-primary-600 to-indigo-700 text-white rounded-lg font-semibold hover:from-primary-700 hover:to-indigo-800 transition-colors shadow-lg mb-4">
                                Explore {{ $hotel->destination->name }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
function changeMainImage(imageSrc, thumbnail) {
    // Update main image
    document.getElementById('main-image').src = imageSrc;
    
    // Remove active class from all thumbnails
    document.querySelectorAll('.grid img').forEach(img => {
        img.parentElement.classList.remove('ring-2', 'ring-blue-500');
    });
    
    // Add active class to clicked thumbnail
    thumbnail.classList.add('ring-2', 'ring-blue-500');
}

// Set minimum date for check-in to today
document.addEventListener('DOMContentLoaded', function() {
    const today = new Date().toISOString().split('T')[0];
    const checkInInput = document.getElementById('check_in');
    const checkOutInput = document.getElementById('check_out');
    
    checkInInput.min = today;
    
    // Update check-out minimum when check-in changes
    checkInInput.addEventListener('change', function() {
        checkOutInput.min = this.value;
        if (checkOutInput.value && checkOutInput.value <= this.value) {
            checkOutInput.value = '';
        }
    });
});
</script>
@endpush