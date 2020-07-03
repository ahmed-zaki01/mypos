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
        $data = [];
        $cats = ['cat one', 'cat two', 'cat three'];

        for ($i = 0; $i < count($cats); $i++) {
            foreach (config('translatable.locales') as $locale) {
                $data += [$locale . '.name' => $cats[$i]];
            }
            Cat::create($data);
            $data = [];
        }
    }
}
