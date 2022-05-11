<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    public function definition() : array
    {
        return [
            'title' => $this->faker->word(),
            'category_id' => null,
        ];
    }
}
