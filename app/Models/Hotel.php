<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $fillable = [
        'destination_id',
        'name',
        'address',
        'amenities',
        'photos',
    ];

    protected $casts = [
        'amenities' => 'array',
        'photos' => 'array',
    ];

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }
}
