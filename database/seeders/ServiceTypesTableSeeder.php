<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;


class ServiceTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $serviceTypes = [
            ['service_type_name' => 'Wash'],
            ['service_type_name' => 'Iron'],
            ['service_type_name' => 'Wash & Dry'],
            ['service_type_name' => 'Wash & Iron'],
            ['service_type_name' => 'Dry Clean'],
        ];

        DB::table('service_types')->insert($serviceTypes);
    
        //
    }
}
