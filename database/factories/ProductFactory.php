<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Smpita\TypeAs\TypeAs;

/**
 * @extends Factory<Product>
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
        $products = [
            [
                'name' => 'Zenith Chronograph Watch',
                'description' => 'A timeless timepiece combining classic craftsmanship with modern precision and a premium leather strap.',
                'image' => '1523275335684-37898b6baf30',
                'min_price' => 25000,
                'max_price' => 45000,
            ],
            [
                'name' => 'Aura Wireless Headphones',
                'description' => 'Immerse yourself in pure sound with advanced active noise cancellation and 40-hour battery life.',
                'image' => '1505740420928-5e560c06d30e',
                'min_price' => 19900,
                'max_price' => 29900,
            ],
            [
                'name' => 'Vanguard Urban Sneakers',
                'description' => 'Lightweight, breathable, and designed for maximum comfort during your daily city explorations.',
                'image' => '1491553895911-0055eca6402d',
                'min_price' => 8500,
                'max_price' => 12500,
            ],
            [
                'name' => 'Crimson Velocity Runners',
                'description' => 'Engineered for speed and endurance, these high-performance running shoes are built for the track.',
                'image' => '1542291026-7eec264c27ff',
                'min_price' => 11000,
                'max_price' => 15000,
            ],
            [
                'name' => 'Lumix Pro Digital Camera',
                'description' => 'Capture every detail with stunning clarity using the latest in mirrorless imaging technology.',
                'image' => '1585333127302-c2c971d4c744',
                'min_price' => 89900,
                'max_price' => 120000,
            ],
            [
                'name' => 'Eclipse Polarized Sunglasses',
                'description' => 'Protect your eyes in style with these premium, polarized designer frames for any occasion.',
                'image' => '1572635196237-14b3f281503f',
                'min_price' => 4500,
                'max_price' => 9500,
            ],
            [
                'name' => 'Nova Instant Retro Camera',
                'description' => 'Instantly capture and print your favorite moments with a classic, vintage film aesthetic.',
                'image' => '1526170315873-3a561629d136',
                'min_price' => 7500,
                'max_price' => 12000,
            ],
        ];

        /** @var array<string, mixed> $product */
        $product = TypeAs::array($this->faker->randomElement($products));
        $name = TypeAs::string($product['name']).' '.$this->faker->unique()->numberBetween(1, 1000);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => TypeAs::string($product['description']),
            'price' => $this->faker->numberBetween(TypeAs::int($product['min_price']), TypeAs::int($product['max_price'])),
            'image_url' => 'https://images.unsplash.com/photo-'.TypeAs::string($product['image']).'?auto=format&fit=crop&q=80&w=800',
        ];
    }
}
