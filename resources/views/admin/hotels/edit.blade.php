@extends('layouts.admin')

@section('title', 'Edit Hotel')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Edit Hotel</h1>
            <a href="{{ route('admin.hotels.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to List
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <form method="POST" action="{{ route('admin.hotels.update', $hotel) }}" enctype="multipart/form-data"
                class="p-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div class="col-span-2">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Hotel Name <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name', $hotel->name) }}" required
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Destination -->
                    <div class="col-span-2">
                        <label for="destination_id" class="block text-sm font-medium text-gray-700 mb-1">Destination <span
                                class="text-red-500">*</span></label>
                        <select name="destination_id" id="destination_id" required
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <option value="">Select Destination</option>
                            @foreach ($destinations as $dest)
                                <option value="{{ $dest->id }}"
                                    {{ old('destination_id', $hotel->destination_id) == $dest->id ? 'selected' : '' }}>
                                    {{ $dest->name }}</option>
                            @endforeach
                        </select>
                        @error('destination_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div class="col-span-2">
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                        <textarea name="address" id="address" rows="3"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">{{ old('address', $hotel->address) }}</textarea>
                        @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Price -->
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Starting Price
                            (USD)</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">$</span>
                            </div>
                            <input type="number" name="price" id="price" step="0.01" min="0"
                                value="{{ old('price', $hotel->price) }}"
                                class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md"
                                placeholder="0.00">
                        </div>
                        @error('price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- SEO Title -->
                    <div>
                        <label for="seo_title" class="block text-sm font-medium text-gray-700 mb-1">SEO Title</label>
                        <input type="text" name="seo_title" id="seo_title"
                            value="{{ old('seo_title', $hotel->seo_title) }}"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                            placeholder="SEO friendly title">
                        @error('seo_title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- SEO Description -->
                    <div class="col-span-2">
                        <label for="seo_description" class="block text-sm font-medium text-gray-700 mb-1">SEO
                            Description</label>
                        <textarea name="seo_description" id="seo_description" rows="3"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                            placeholder="Brief description for search engines (max 500 characters)">{{ old('seo_description', $hotel->seo_description) }}</textarea>
                        <p class="text-sm text-gray-500 mt-1">Recommended: 150-160 characters</p>
                        @error('seo_description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Current SEO Image -->
                    @if ($hotel->seo_image)
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Current SEO Image</label>
                            <div class="current-seo-image mb-4">
                                <img src="{{ asset('storage/' . $hotel->seo_image) }}" alt="Current SEO Image"
                                    class="w-64 h-32 object-cover rounded-lg">
                                <label class="flex items-center mt-2">
                                    <input type="checkbox" name="remove_seo_image" value="1"
                                        class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-600">Remove current SEO image</span>
                                </label>
                            </div>
                        </div>
                    @endif

                    <!-- SEO Image -->
                    <div class="col-span-2">
                        <label for="seo_image" class="block text-sm font-medium text-gray-700 mb-1">
                            {{ $hotel->seo_image ? 'Replace SEO Image' : 'SEO Image' }}
                        </label>
                        <div class="seo-image-upload p-4 border border-gray-200 rounded-lg">
                            <input type="file" name="seo_image" id="seo_image" accept="image/*"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            <div class="seo-image-preview mt-2" style="display: none;">
                                <img src="" alt="SEO Preview" class="w-64 h-32 object-cover rounded-lg">
                            </div>
                        </div>
                        <p class="text-sm text-gray-500 mt-1">Recommended size: 1200x630px for social media sharing</p>
                        @error('seo_image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Amenities -->
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Amenities</label>
                        <div id="amenities-container">
                            @if (old('amenities', $hotel->amenities))
                                @foreach (old('amenities', $hotel->amenities) as $amenity)
                                    <div class="amenity-item flex mb-2">
                                        <input type="text" name="amenities[]" value="{{ $amenity }}"
                                            placeholder="Enter amenity"
                                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                        <button type="button"
                                            class="ml-2 px-3 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 remove-amenity">Remove</button>
                                    </div>
                                @endforeach
                            @else
                                <div class="amenity-item flex mb-2">
                                    <input type="text" name="amenities[]" placeholder="Enter amenity"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <button type="button"
                                        class="ml-2 px-3 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 remove-amenity">Remove</button>
                                </div>
                            @endif
                        </div>
                        <button type="button" id="add-amenity"
                            class="mt-2 px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">Add
                            Amenity</button>
                        @error('amenities')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Existing Photos -->
                    @if ($hotel->photos && count($hotel->photos) > 0)
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Existing Photos</label>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                                @foreach ($hotel->photos as $index => $photo)
                                    <div class="existing-photo-item relative">
                                        <img src="{{ asset('storage/' . $photo) }}" alt="Hotel Photo"
                                            class="w-full h-32 object-cover rounded-lg">
                                        <input type="hidden" name="existing_photos[]" value="{{ $photo }}"
                                            class="existing-photo-input">
                                        <button type="button"
                                            class="absolute top-2 right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600 remove-existing-photo">
                                            ×
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- New Photos -->
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Add New Photos</label>
                        <div id="photos-container">
                            <div class="photo-item mb-4 p-4 border border-gray-200 rounded-lg">
                                <input type="file" name="photos[]" accept="image/*"
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                <button type="button"
                                    class="mt-2 px-3 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 remove-photo">Remove</button>
                                <div class="photo-preview mt-2" style="display: none;">
                                    <img src="" alt="Preview" class="w-32 h-32 object-cover rounded-lg">
                                </div>
                            </div>
                        </div>
                        <button type="button" id="add-photo"
                            class="mt-2 px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">Add Photo</button>
                        <p class="text-sm text-gray-500 mt-1">Maximum 10 photos total. Accepted formats: JPEG, PNG, JPG,
                            GIF. Max size: 2MB per photo.</p>
                        @error('photos')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        @error('photos.*')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Update Hotel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add amenity functionality
            document.getElementById('add-amenity').addEventListener('click', function() {
                const container = document.getElementById('amenities-container');
                const newItem = document.createElement('div');
                newItem.className = 'amenity-item flex mb-2';
                newItem.innerHTML = `
            <input type="text" name="amenities[]" placeholder="Enter amenity" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
            <button type="button" class="ml-2 px-3 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 remove-amenity">Remove</button>
        `;
                container.appendChild(newItem);
            });

            // Add photo functionality
            document.getElementById('add-photo').addEventListener('click', function() {
                const container = document.getElementById('photos-container');
                const existingPhotos = document.querySelectorAll('.existing-photo-item:not(.removed)')
                    .length;
                const newPhotos = container.children.length;

                if (existingPhotos + newPhotos >= 10) {
                    alert('Maximum 10 photos allowed');
                    return;
                }

                const newItem = document.createElement('div');
                newItem.className = 'photo-item mb-4 p-4 border border-gray-200 rounded-lg';
                newItem.innerHTML = `
            <input type="file" name="photos[]" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            <button type="button" class="mt-2 px-3 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 remove-photo">Remove</button>
            <div class="photo-preview mt-2" style="display: none;">
                <img src="" alt="Preview" class="w-32 h-32 object-cover rounded-lg">
            </div>
        `;
                container.appendChild(newItem);

                // Add file preview functionality to the new input
                setupFilePreview(newItem.querySelector('input[type="file"]'));
            });

            // Remove amenity/photo functionality
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-amenity')) {
                    e.target.closest('.amenity-item').remove();
                }
                if (e.target.classList.contains('remove-photo')) {
                    e.target.closest('.photo-item').remove();
                }
                if (e.target.classList.contains('remove-existing-photo')) {
                    const photoItem = e.target.closest('.existing-photo-item');
                    photoItem.classList.add('removed');
                    photoItem.style.display = 'none';
                    photoItem.querySelector('.existing-photo-input').remove();
                }
            });

            // Setup file preview for existing inputs
            document.querySelectorAll('input[type="file"]').forEach(setupFilePreview);

            // Setup SEO image preview
            document.getElementById('seo_image').addEventListener('change', function(e) {
                const file = e.target.files[0];
                const previewContainer = document.querySelector('.seo-image-preview');
                const previewImg = previewContainer.querySelector('img');

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        previewContainer.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                } else {
                    previewContainer.style.display = 'none';
                }
            });

            function setupFilePreview(input) {
                input.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    const previewContainer = e.target.parentNode.querySelector('.photo-preview');
                    const previewImg = previewContainer.querySelector('img');

                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            previewImg.src = e.target.result;
                            previewContainer.style.display = 'block';
                        };
                        reader.readAsDataURL(file);
                    } else {
                        previewContainer.style.display = 'none';
                    }
                });
            }
        });
    </script>
@endsection
