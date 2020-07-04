<?php

use App\Cat;
use Illuminate\Database\Seeder;

class CatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cats = ['cat one', 'cat two', 'cat three'];

        foreach ($cats as $cat) {
            Cat::create([
                'en' => ['name' => $cat],
                'ar' => ['name' => $cat],
            ]);
        }
    }
}
