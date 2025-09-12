<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

class ProductFactory extends Factory
{
    protected $model = \App\Models\Product::class;

    public function definition(): array
    {
        // Random category choose karne ke liye ensure categories seed ho chuki hain
        $categoryIds = Category::pluck('id')->toArray();

        return [
            'name'        => $this->faker->word(),
            'slug'        => $this->faker->slug(),
            'description' => $this->faker->sentence(10),
            'price'       => $this->faker->numberBetween(100, 1000),
            'stock'       => $this->faker->numberBetween(10, 100),
            'category_id' => $this->faker->randomElement($categoryIds),
        ];
    }
}
