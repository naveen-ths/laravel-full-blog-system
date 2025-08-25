<?php

namespace Database\Seeders;

use App\Models\Slide;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SlideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 5 active slides with specific data
        $slides = [
            [
                'name' => 'Welcome to Our Platform',
                'description' => 'Discover amazing features and capabilities that will transform your experience.',
                'image' => 'https://picsum.photos/1200/500?random=1',
                'image_alt' => 'Welcome slide showing platform overview',
                'link_url' => '/featured-pages',
                'link_text' => 'Explore Features',
                'link_new_tab' => false,
                'status' => 'active',
                'sort_order' => 1,
            ],
            [
                'name' => 'Powerful Content Management',
                'description' => 'Create, manage, and publish content with our intuitive content management system.',
                'image' => 'https://picsum.photos/1200/500?random=2',
                'image_alt' => 'Content management interface',
                'link_url' => '/pages',
                'link_text' => 'Manage Content',
                'link_new_tab' => false,
                'status' => 'active',
                'sort_order' => 2,
            ],
            [
                'name' => 'Beautiful Design',
                'description' => 'Experience modern, responsive design that works perfectly on all devices.',
                'image' => 'https://picsum.photos/1200/500?random=3',
                'image_alt' => 'Responsive design showcase',
                'link_url' => null,
                'link_text' => null,
                'link_new_tab' => false,
                'status' => 'active',
                'sort_order' => 3,
            ],
            [
                'name' => 'Advanced Features',
                'description' => 'Take advantage of advanced features including SEO optimization, image management, and more.',
                'image' => 'https://picsum.photos/1200/500?random=4',
                'image_alt' => 'Advanced features overview',
                'link_url' => 'https://laravel.com/docs',
                'link_text' => 'Learn More',
                'link_new_tab' => true,
                'status' => 'active',
                'sort_order' => 4,
            ],
            [
                'name' => 'Get Started Today',
                'description' => 'Join thousands of satisfied users and start your journey with us today.',
                'image' => 'https://picsum.photos/1200/500?random=5',
                'image_alt' => 'Get started call to action',
                'link_url' => '/register',
                'link_text' => 'Sign Up Now',
                'link_new_tab' => false,
                'status' => 'active',
                'sort_order' => 5,
            ],
        ];

        foreach ($slides as $slideData) {
            Slide::create($slideData);
        }

        // Create additional random slides
        Slide::factory()->active()->count(3)->create([
            'sort_order' => fake()->numberBetween(6, 10)
        ]);

        // Create some inactive slides
        Slide::factory()->inactive()->count(2)->create([
            'sort_order' => fake()->numberBetween(11, 15)
        ]);
    }
}
