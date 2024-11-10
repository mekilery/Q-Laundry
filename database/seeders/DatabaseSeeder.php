<?php

namespace Database\Seeders;

use App\Models\FinancialYear;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       User::create([
           'name'   => 'Admin',
           'email'  => 'admin@admin.com',
           'password'   => \Hash::make('123456'),
            'user_type' => 1,
       ]);
       /* seeder call */
        $this->call([
            MasterControlSeeder::class,
            CountryControlSeeder::class,
        ]);
       
    }
}