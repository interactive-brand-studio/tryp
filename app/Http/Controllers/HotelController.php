<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Support\Facades\Log;

class HotelController extends Controller
{
    public function show(Hotel $hotel)
    {
        return view('hotels.show', compact('hotel'));
    }

    public function getHotel(Hotel $hotel)
    {
        try {

            // Prepare photo URLs - handle both storage paths and direct URLs
            $photoUrls = [];
            if ($hotel->photos && is_array($hotel->photos)) {
                foreach ($hotel->photos as $photo) {
                    if (filter_var($photo, FILTER_VALIDATE_URL)) {
                        // If it's already a full URL, use it as is
                        $photoUrls[] = $photo;
                    } else {
                        // If it's a storage path, prepend the storage URL
                        $photoUrls[] = asset('storage/' . $photo);
                    }
                }
            }

            // Prepare SEO image URL
            $seoImageUrl = null;
            if ($hotel->seo_image) {
                if (filter_var($hotel->seo_image, FILTER_VALIDATE_URL)) {
                    $seoImageUrl = $hotel->seo_image;
                } else {
                    $seoImageUrl = asset('storage/' . $hotel->seo_image);
                }
            }

            // Prepare amenities (ensure it's always an array)
            $amenities = [];
            if ($hotel->amenities) {
                $amenities = is_array($hotel->amenities) ? $hotel->amenities : json_decode($hotel->amenities, true) ?? [];
            }

            // Get first photo URL or default
            $firstPhotoUrl = count($photoUrls) > 0 ? $photoUrls[0] : asset('images/default-hotel.jpg');

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $hotel->id,
                    'name' => $hotel->name,
                    'address' => $hotel->address,
                    'price' => $hotel->price ? (float) $hotel->price : null,
                    'formatted_price' => $hotel->price ? '$' . number_format($hotel->price, 2) : null,
                    'price_display' => $hotel->price ? 'Starting from $' . number_format($hotel->price, 0) : 'Contact for pricing',
                    'seo_title' => $hotel->seo_title ?: $hotel->name,
                    'seo_description' => $hotel->seo_description,
                    'seo_image_url' => $seoImageUrl ?: $firstPhotoUrl,
                    'amenities' => $amenities,
                    'amenities_count' => count($amenities),
                    'photos' => $hotel->photos ?: [],
                    'photo_urls' => $photoUrls,
                    'photos_count' => count($photoUrls),
                    'first_photo_url' => $firstPhotoUrl,
                    'has_photos' => count($photoUrls) > 0,
                    'destination' => [
                        'id' => $hotel->destination->id,
                        'name' => $hotel->destination->name,
                        'location' => $hotel->destination->location,
                        'full_location' => $hotel->destination->name . ', ' . $hotel->destination->location,
                    ],
                    'meta' => [
                        'created_at' => $hotel->created_at->toDateTimeString(),
                        'updated_at' => $hotel->updated_at->toDateTimeString(),
                        'created_at_human' => $hotel->created_at->diffForHumans(),
                        'updated_at_human' => $hotel->updated_at->diffForHumans(),
                    ]
                ]
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'error' => 'Hotel not found',
                'message' => 'The requested hotel could not be found.',
                'error_code' => 'HOTEL_NOT_FOUND'
            ], 404);
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Hotel API Error: ' . $e->getMessage(), [
                'hotel_id' => $hotel->id,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Server error',
                'message' => 'An error occurred while loading the hotel details. Please try again.',
                'error_code' => 'SERVER_ERROR'
            ], 500);
        }
    }
}
