<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->sentence(5);

        return [
            'category_id' => Category::factory(),
            'title' => $title,
            'slug' => Str::slug($title).'-'.Str::lower(Str::random(5)),
            'author' => fake()->name(),
            'excerpt' => fake()->paragraph(1),
            'body' => fake()->paragraphs(4, true),
            'is_published' => true,
            'is_featured' => false,
            'views' => fake()->numberBetween(0, 200),
            'published_at' => now()->subDays(fake()->numberBetween(1, 30)),
        ];
    }
}
