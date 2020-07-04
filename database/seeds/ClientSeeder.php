<?php

use App\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Client::create([
            'name' => 'ahmed zaki',
            'phone' => ['01008781070', null],
            'address' => 'helwan, cairo',
        ]);

        Client::create([
            'name' => 'kareem fouad',
            'phone' => ['01129321070', null],
            'address' => 'nasr city, cairo',
        ]);

        Client::create([
            'name' => 'mohamed mohsen',
            'phone' => ['01006582158', null],
            'address' => 'haram, giza',
        ]);
    }
}
