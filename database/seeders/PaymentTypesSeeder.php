<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $paymentTypes = [
            ['name' => 'Cash', 'is_active' => true],
            ['name' => 'Benefit', 'is_active' => true],
            ['name' => 'Card', 'is_active' => true],
            ['name' => 'Credit', 'is_active' => true],
        ];
        DB::table('payment_types')->insert($paymentTypes);
    }
}
