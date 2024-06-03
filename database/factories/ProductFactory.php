<?php

namespace Database\Factories;

use App\Models\User;
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
    public function definition(): array
    {
        $latitude = $this->faker->latitude;
        $longitude = $this->faker->longitude;
        $googleMapsLink = "https://www.google.com/maps?q={$latitude},{$longitude}";

        return [
            'productname' => $this->faker->unique()->word,
            'ownerId' => User::factory(),
            'location' => $this->faker->address,
            'category' => $this->faker->randomElement(['Pria', 'Wanita']),
            'fasilitas' => implode(',', $this->faker->words(3)),
            'price' => $this->faker->numberBetween($min = 150000, $max = 1500000),
            'roomid' => $this->faker->numberBetween(1, 100),
            'about' => $this->faker->paragraph,
            'image' => $this->faker->imageUrl(640, 480, 'products', true),
            'linklocation' => $googleMapsLink,
        ];
    }


}
