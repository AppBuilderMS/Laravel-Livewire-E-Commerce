<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $product_name = $this->faker->unique()->words($nb=2,$asText=true).' '.$this->faker->unique()->numberBetween(1, 500);
        return [
            'name' => $product_name,
            'description' => $this->faker->text(200),
            'details' => $this->faker->text(500),
            'regular_price' => $this->faker->numberBetween(10,500),
            'SKU' => 'DIGI'.$this->faker->unique()->numberBetween(100,500),
            'stock_status' => 'instock',
            'quantity' => $this->faker->numberBetween(100,200),
            'image' => 'product-'.$this->faker->unique()->numberBetween(1, 67).'.jpg',
            'category_id' => $this->faker->numberBetween(1,6),
            'subcategory_id' => $this->faker->numberBetween(1,18),
        ];
    }
}
