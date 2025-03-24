<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Product;
use App\Models\Address;
use App\Models\Payment;

class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'product_id' => Product::inRandomOrder()->first()->id,
            'payment_type' => $this->faker->randomElement(['クレジットカード', 'コンビニ払い', '銀行振込']),
            'shipping_postal_code' => $this->faker->postcode,
            'shipping_address' => $this->faker->address,
            'shipping_building' => $this->faker->secondaryAddress,
        ];
    }
}
