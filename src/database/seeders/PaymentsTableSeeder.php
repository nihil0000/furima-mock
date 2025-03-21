<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payment;

class PaymentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $payment_types = ['コンビニ支払い', 'カード支払い'];

        foreach ($payment_types as $payment_type) {
            Payment::create(['payment_type' => $payment_type]);
        }
    }
}
