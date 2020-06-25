<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\User::create([
            'first_name' => 'super',
            'last_name' => 'admin',
            'email' => 'superadmin@mypos.com',
            'password' => bcrypt('123456'),
        ]);

        // $scdUser = \App\User::create([
        //     'first_name' => 'super',
        //     'last_name' => 'admin2',
        //     'email' => 'superadmin2@mypos.com',
        //     'password' => bcrypt('123456'),
        // ]);

        $user->attachRole('super_admin');
        //$user->attachRole('super_admin');
        $this->command->info("Assigning super_admin role to $user->first_name-$user->last_name user");
    } //end of run
}//end of seeder
