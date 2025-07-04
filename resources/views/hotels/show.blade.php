@extends('layouts.app')
@section('title', $hotel->name)
@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">{{ $hotel->name }}</h1>
        <p>{{ $hotel->address }}</p>
        @if ($hotel->amenities)
            <ul>
                @foreach ($hotel->amenities as $amenity)
                    <li>{{ $amenity }}</li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
