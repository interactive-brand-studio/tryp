<?php

namespace App\Http\Controllers;

use App\Models\Admin\TravelPackage;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Faq;

class TiersController extends Controller
{
    /**
     * Display the packages index.
     */
    public function index()
    {
        // Get active travel packages ordered by sort_order
        $travelPackages = TravelPackage::where('status', 'active')
            ->orderBy('sort_order')
            ->get();
        
        $faqCategories = Faq::active()
            ->ordered()
            ->get()
            ->groupBy('category');
        // Pass the $travelPackages variable to the view
        return view('tiers.index', compact('travelPackages','faqCategories'));
    }

    /**
     * Display the specified package.
     */
    public function show($type)
    {
        // Find the package by type
        $package = TravelPackage::where('type', $type)
            ->where('status', 'active')
            ->firstOrFail();
            
        $packageType = $type;
        $packageName = $package->name;
        $packageDescription = $package->short_description ?? 'Premium vacation package';
        $packagePrice = $package->price;
        
        return view('tiers.show', compact(
            'packageType',
            'packageName',
            'packageDescription',
            'packagePrice',
            'package'
        ));
    }

    /**
     * Process the booking form.
     */
    public function book(Request $request)
    {
        // Validate booking data
        $validated = $request->validate([
            'package_type' => 'required|string',
            'package_price' => 'required|numeric',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'card_number' => 'required|string|max:19',
            'cardholder_name' => 'required|string|max:255',
            'expiration_month' => 'required|numeric|min:1|max:12',
            'expiration_year' => 'required|numeric|min:2023',
            'cvv' => 'required|string|max:4',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:2',
            'zip' => 'required|string|max:10',
            'consent' => 'required',
        ]);
        
        // Find the package by type
        $package = TravelPackage::where('type', $validated['package_type'])->firstOrFail();
        
        // Create a new booking in the database
        $booking = Booking::create([
            'user_id' => Auth::id(), // Will be null if user is not logged in
            'package_type' => $validated['package_type'],
            'package_name' => $package->name,
            'package_price' => $validated['package_price'],
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'city' => $validated['city'],
            'state' => $validated['state'],
            'zip' => $validated['zip'],
            'payment_method' => 'credit_card',
            'card_last_four' => substr($validated['card_number'], -4), // Store only last 4 digits for security
            'status' => 'pending'
        ]);
        
        // For the thank you page, we prepare a booking array
        $bookingData = [
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'email' => $validated['email'],
            'package' => $package->name,
            'price' => $validated['package_price'],
        ];

        return redirect()->route('tiers.thankyou')->with('booking', $bookingData);
    }

    /**
     * Display the thank you page after booking.
     */
    public function thankYou()
    {
        if (!session('booking')) {
            return redirect()->route('tiers.index');
        }

        $booking = session('booking');
        
        return view('tiers.thankyou', compact('booking'));
    }
}