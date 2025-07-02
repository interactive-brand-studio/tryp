<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'type',
        'slug',
        'description',
        'short_description',
        'price',
        'image',
        'features',
        'status',
        'sort_order',
        'is_featured'
    ];

    protected $casts = [
        'features' => 'array',
        'price' => 'float',
        'is_featured' => 'boolean',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}