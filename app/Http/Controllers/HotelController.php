<?php

namespace App\Http\Controllers;

use App\Models\Hotel;

class HotelController extends Controller
{
    public function show(Hotel $hotel)
    {
        return view('hotels.show', compact('hotel'));
    }
}
