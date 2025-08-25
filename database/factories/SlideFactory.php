<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Slide>
 */
class SlideFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'image' => 'https://picsum.photos/1200/500?random=' . $this->faker->numberBetween(1, 1000),
            'image_alt' => $this->faker->sentence(2),
            'link_url' => $this->faker->optional(0.7)->url(),
            'link_text' => $this->faker->optional(0.7)->words(2, true),
            'link_new_tab' => $this->faker->boolean(30),
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'sort_order' => $this->faker->numberBetween(0, 100),
        ];
    }

    /**
     * Indicate that the slide is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
        ]);
    }

    /**
     * Indicate that the slide is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'inactive',
        ]);
    }
}
