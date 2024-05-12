<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Product;



class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();

        // Generate fake data and insert into the products table
        for ($i = 0; $i < 10; $i++) {
            $name = $faker->words($nb = 3, $asText = true); // Generate a string of maximum 3 words
            $name = substr($name, 0, 255); // Limit the name to 255 characters
            Product::create([
                'name' => $name,
                'description' => $faker->paragraph,
                'price' => $faker->numberBetween(10, 100),
                'category' => $faker->randomElement(['protein', 'kreatin']),
                'sale_percentage' => $faker->randomElement([$faker->numberBetween(5, 90), 0]),
                'availability' => $faker->numberBetween(1, 100),
                'image_path' => $faker->imageUrl(), // Generates a random image URL
                'created_at' => $faker->dateTimeBetween('-1 year', 'now'),
                'updated_at' => $faker->dateTimeBetween('-1 year', 'now'),
            ]);
        }
    }
}