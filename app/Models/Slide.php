<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image',
        'image_alt',
        'link_url',
        'link_text',
        'link_new_tab',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'link_new_tab' => 'boolean',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }

    // Accessors
    public function getImageUrlAttribute()
    {
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }
        return asset('storage/' . $this->image);
    }

    public function getLinkTargetAttribute()
    {
        return $this->link_new_tab ? '_blank' : '_self';
    }
}
