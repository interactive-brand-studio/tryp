<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\Destination;
use Illuminate\Http\Request;

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
            'amenities' => 'nullable|array',
            'amenities.*' => 'string',
            'photos' => 'nullable|array',
            'photos.*' => 'string',
        ]);

        Hotel::create($data);

        return redirect()->route('admin.hotels.index');
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
            'amenities' => 'nullable|array',
            'amenities.*' => 'string',
            'photos' => 'nullable|array',
            'photos.*' => 'string',
        ]);

        $hotel->update($data);

        return redirect()->route('admin.hotels.index');
    }

    public function destroy(Hotel $hotel)
    {
        $hotel->delete();
        return redirect()->route('admin.hotels.index');
    }
}
