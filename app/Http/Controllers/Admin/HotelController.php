<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HotelController extends Controller
{
    public function index()
    {
        $hotels = Hotel::with('destination')->paginate(10);
        return view('admin.hotels.index', compact('hotels'));
    }

    public function create()
    {
        $destinations = Destination::all();
        return view('admin.hotels.create', compact('destinations'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'destination_id' => 'required|exists:destinations,id',
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:500',
            'amenities' => 'nullable|array',
            'amenities.*' => 'string',
            'photos' => 'nullable|array|max:10',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'seo_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Handle photo uploads
        $photoPaths = [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('hotels', 'public');
                $photoPaths[] = $path;
            }
        }

        // Handle SEO image upload
        if ($request->hasFile('seo_image')) {
            $data['seo_image'] = $request->file('seo_image')->store('hotels/seo', 'public');
        }

        // Replace photos array with file paths
        $data['photos'] = $photoPaths;

        Hotel::create($data);

        return redirect()->route('admin.hotels.index')
            ->with('success', 'Hotel created successfully!');
    }

    public function edit(Hotel $hotel)
    {
        $destinations = Destination::all();
        return view('admin.hotels.edit', compact('hotel', 'destinations'));
    }

    public function update(Request $request, Hotel $hotel)
    {
        $data = $request->validate([
            'destination_id' => 'required|exists:destinations,id',
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:500',
            'amenities' => 'nullable|array',
            'amenities.*' => 'string',
            'photos' => 'nullable|array|max:10',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'seo_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'existing_photos' => 'nullable|array',
            'remove_seo_image' => 'nullable|boolean',
        ]);

        // Handle photo uploads
        $photoPaths = [];

        // Keep existing photos that weren't removed
        if ($request->has('existing_photos')) {
            $photoPaths = $request->existing_photos;
        }

        // Add new uploaded photos
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('hotels', 'public');
                $photoPaths[] = $path;
            }
        }

        // Delete old photos that are no longer needed
        $oldPhotos = $hotel->photos ?? [];
        $photosToDelete = array_diff($oldPhotos, $photoPaths);

        foreach ($photosToDelete as $photoPath) {
            Storage::disk('public')->delete($photoPath);
        }

        // Handle SEO image
        if ($request->hasFile('seo_image')) {
            // Delete old SEO image
            if ($hotel->seo_image) {
                Storage::disk('public')->delete($hotel->seo_image);
            }
            $data['seo_image'] = $request->file('seo_image')->store('hotels/seo', 'public');
        } elseif ($request->has('remove_seo_image') && $request->remove_seo_image) {
            // Remove SEO image if requested
            if ($hotel->seo_image) {
                Storage::disk('public')->delete($hotel->seo_image);
            }
            $data['seo_image'] = null;
        }

        $data['photos'] = $photoPaths;

        $hotel->update($data);

        return redirect()->route('admin.hotels.index')
            ->with('success', 'Hotel updated successfully!');
    }

    public function destroy(Hotel $hotel)
    {
        // Delete associated photos from storage
        if ($hotel->photos) {
            foreach ($hotel->photos as $photoPath) {
                Storage::disk('public')->delete($photoPath);
            }
        }

        // Delete SEO image from storage
        if ($hotel->seo_image) {
            Storage::disk('public')->delete($hotel->seo_image);
        }

        $hotel->delete();

        return redirect()->route('admin.hotels.index')
            ->with('success', 'Hotel deleted successfully!');
    }

    // Add method to get hotels by destination (for frontend)
    public function getByDestination($destinationId)
    {
        $hotels = Hotel::where('destination_id', $destinationId)
            ->orderBy('price', 'asc')
            ->get();

        return response()->json($hotels);
    }
}
