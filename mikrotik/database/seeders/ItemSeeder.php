<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use Faker\Factory as Faker;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $categories = ['Electronics', 'Furniture', 'Office Supplies', 'Tools', 'Books', 'Clothing'];
        $suppliers = ['PT Supplier A', 'CV Supplier B', 'Toko Supplier C', 'UD Supplier D'];
        $locations = ['Warehouse A', 'Warehouse B', 'Storage Room 1', 'Storage Room 2'];

        for ($i = 1; $i <= 50; $i++) {
            $quantity = $faker->numberBetween(0, 100);
            $price = $faker->numberBetween(10000, 5000000);

            $item = Item::create([
                'name' => $faker->words(3, true),
                'code' => 'ITM' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'description' => $faker->sentence(),
                'quantity' => $quantity,
                'price' => $price,
                'category' => $faker->randomElement($categories),
                'location' => $faker->randomElement($locations),
                'purchase_date' => $faker->dateTimeBetween('-1 year', 'now'),
                'supplier' => $faker->randomElement($suppliers),
            ]);

            $item->updateStatus();
        }
    }
}