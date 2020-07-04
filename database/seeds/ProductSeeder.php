<?php

use App\Cat;
use App\Product;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $products = ['prod one', 'prod two', 'prod three', 'prod four'];

        $cats = Cat::pluck('id')->toArray();
        foreach ($products as $product) {
            Product::create([
                'cat_id' => $faker->randomElement($cats),
                'en' => ['name' => $product, 'desc' => $product . 'desc'],
                'ar' => ['name' => $product, 'desc' => $product . 'desc'],
                'purchase_price' => $faker->randomNumber(3),
                'sell_price' => $faker->randomNumber(3),
                'stock' => 100

            ]);
        } // end of foreach

    }
}
