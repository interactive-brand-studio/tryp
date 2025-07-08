<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'destination_id',
        'name',
        'address',
        'price',
        'seo_title',
        'seo_description',
        'seo_image',
        'amenities',
        'photos'
    ];

    protected $casts = [
        'amenities' => 'array',
        'photos' => 'array',
    ];

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    // Helper method to get photo URLs
    public function getPhotoUrlsAttribute()
    {
        if (!$this->photos) {
            return [];
        }

        return array_map(function ($photo) {
            return asset('storage/' . $photo);
        }, $this->photos);
    }

    // Helper method to get SEO image URL
    public function getSeoImageUrlAttribute()
    {
        if (!$this->seo_image) {
            return $this->first_photo_url; // Fallback to first photo
        }

        return asset('storage/' . $this->seo_image);
    }

    // Helper method to get formatted price
    public function getFormattedPriceAttribute()
    {
        if (!$this->price) {
            return 'Contact for pricing';
        }

        return 'Starting from $' . number_format($this->price, 2);
    }

    // Scope to filter by destination
    public function scopeByDestination($query, $destinationId)
    {
        return $query->where('destination_id', $destinationId);
    }

    // Scope to order by price
    public function scopeOrderByPrice($query, $direction = 'asc')
    {
        return $query->orderBy('price', $direction);
    }
}
