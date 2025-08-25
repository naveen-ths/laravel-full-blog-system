<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Page>
 */
class PageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(3, true);
        $slug = \Illuminate\Support\Str::slug($title);
        
        return [
            'title' => $title,
            'slug' => $slug,
            'content' => fake()->paragraphs(5, true),
            'excerpt' => fake()->text(200),
            'status' => fake()->randomElement(['draft', 'published', 'private']),
            'sort_order' => fake()->numberBetween(1, 100),
            'is_featured' => fake()->boolean(20), // 20% chance of being featured
            'published_at' => fake()->optional(0.8)->dateTimeBetween('-1 year', 'now'),
            
            // SEO fields
            'meta_title' => fake()->optional(0.7)->sentence(4, true),
            'meta_description' => fake()->optional(0.7)->text(160),
            'meta_keywords' => fake()->optional(0.5)->words(5, true),
            'meta_robots' => 'index,follow',
            'canonical_url' => fake()->optional(0.3)->url(),
            'og_data' => fake()->optional(0.6)->passthrough([
                'title' => $title,
                'description' => fake()->text(100),
                'image' => fake()->imageUrl(1200, 630),
                'type' => 'article'
            ]),
            'twitter_data' => fake()->optional(0.4)->passthrough([
                'card' => 'summary_large_image',
                'title' => $title,
                'description' => fake()->text(100),
                'image' => fake()->imageUrl(1200, 600)
            ]),
            'schema_markup' => fake()->optional(0.3)->json(),
            
            // Featured image fields
            'featured_image' => fake()->optional(0.8)->imageUrl(800, 400),
            'featured_image_alt' => fake()->optional(0.7)->sentence(3),
            'featured_image_caption' => fake()->optional(0.4)->sentence(4),
            'featured_image_meta' => fake()->optional(0.8)->passthrough([
                'width' => fake()->numberBetween(600, 1200),
                'height' => fake()->numberBetween(300, 800),
                'file_size' => fake()->numberBetween(50000, 500000)
            ]),
            
            // Additional media fields
            'gallery_images' => fake()->optional(0.3)->passthrough([
                [
                    'url' => fake()->imageUrl(600, 400),
                    'alt' => fake()->sentence(3),
                    'caption' => fake()->optional()->sentence(4)
                ],
                [
                    'url' => fake()->imageUrl(600, 400),
                    'alt' => fake()->sentence(3),
                    'caption' => fake()->optional()->sentence(4)
                ]
            ]),
            'banner_image' => fake()->optional(0.5)->imageUrl(1200, 300),
            'banner_image_alt' => fake()->optional(0.4)->sentence(3),
            
            // User relationships
            'author_id' => \App\Models\User::factory(),
            'updated_by' => function (array $attributes) {
                return $attributes['author_id'];
            },
        ];
    }
}
