<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        factory(\App\Models\User::class,5)->create();
        factory(\App\Models\Wallet::class, 5)->create();
        factory(\App\Models\Address::class, 5)->create();
        factory(\App\Models\Device::class, 5)->create();

    }
}
