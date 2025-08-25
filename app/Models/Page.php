<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'status',
        'sort_order',
        'is_featured',
        'published_at',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'meta_robots',
        'canonical_url',
        'og_data',
        'twitter_data',
        'schema_markup',
        'featured_image',
        'featured_image_alt',
        'featured_image_caption',
        'featured_image_meta',
        'gallery_images',
        'banner_image',
        'banner_image_alt',
        'author_id',
        'updated_by',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
        'og_data' => 'array',
        'twitter_data' => 'array',
        'featured_image_meta' => 'array',
        'gallery_images' => 'array',
    ];

    protected $dates = [
        'published_at',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($page) {
            if (empty($page->slug)) {
                $page->slug = Str::slug($page->title);
            }
        });
    }

    /**
     * Get the author of the page.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Get the user who last updated the page.
     */
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Scope a query to only include published pages.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->where('published_at', '<=', now());
    }

    /**
     * Scope a query to only include featured pages.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Get the page's full URL.
     */
    public function getUrlAttribute()
    {
        return url('/' . $this->slug);
    }

    /**
     * Get the page's SEO title.
     */
    public function getSeoTitleAttribute()
    {
        return $this->meta_title ?: $this->title;
    }

    /**
     * Get the page's SEO description.
     */
    public function getSeoDescriptionAttribute()
    {
        return $this->meta_description ?: $this->excerpt;
    }
}
