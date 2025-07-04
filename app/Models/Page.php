<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'seo_title',
        'seo_description',
        'seo_image',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
