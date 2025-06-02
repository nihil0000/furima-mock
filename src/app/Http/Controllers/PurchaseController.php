<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\ShipAddressRequest;
use App\Models\Product;
use App\Models\Order;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Checkout\Session;

class PurchaseController extends Controller
{
    // Purchase details
    public function show(Product $product)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $user->load('address');

        $sessionKey = 'purchase_address_' . $product->id;
        $sessionAddress = session($sessionKey);

        $address = $sessionAddress ?? [
            'postal_code' => $user->address->postal_code ?? '',
            'address'     => $user->address->address ?? '',
            'building'    => $user->address->building ?? '',
        ];

        // Stripeの公開可能キーを設定
        $stripeKey = config('stripe.key');

        return view('purchase.checkout', compact('address', 'product', 'stripeKey'));
    }


    // Show edit address form
    public function create(Product $product)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $user->load('address');

        $sessionKey = 'purchase_address_' . $product->id;
        $sessionAddress = session($sessionKey);

        $address = $sessionAddress ?? [
            'postal_code' => $user->address->postal_code ?? '',
            'address'     => $user->address->address ?? '',
            'building'    => $user->address->building ?? '',
        ];

        return view('purchase.edit', compact('address', 'product'));
    }


    // Edit address
    public function update(ShipAddressRequest $request, Product $product)
    {
        session([
            'purchase_address_' . $product->id => [
                'postal_code' => $request->postal_code,
                'address' => $request->address,
                'building' => $request->building,
            ],
        ]);

        return redirect()->route('purchase.show', compact('product'));
    }


    // Create Stripe Checkout Session
    public function createCheckoutSession(Request $request, Product $product)
    {
        // 配送先情報のバリデーション
        $sessionKey = 'purchase_address_' . $product->id;
        $sessionAddress = session($sessionKey);

        if (empty($sessionAddress['postal_code']) || empty($sessionAddress['address']) || empty($sessionAddress['building'])) {
            return response()->json(['error' => '配送先住所を登録してください'], 422);
        }

        try {
            Stripe::setApiKey(config('stripe.secret'));

            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'jpy',
                        'product_data' => [
                            'name' => $product->product_name,
                        ],
                        'unit_amount' => $product->price,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('purchase.success', ['product' => $product->id]),
                'cancel_url' => route('purchase.show', ['product' => $product->id]),
                'metadata' => [
                    'product_id' => $product->id,
                    'user_id' => auth()->id(),
                ],
                // 'shipping_address_collection' => [
                //     'allowed_countries' => ['JP'],
                // ],
                'shipping_options' => [
                    [
                        'shipping_rate_data' => [
                            'type' => 'fixed_amount',
                            'fixed_amount' => [
                                'amount' => 0,
                                'currency' => 'jpy',
                            ],
                            'display_name' => '日本国内配送',
                            'delivery_estimate' => [
                                'minimum' => [
                                    'unit' => 'business_day',
                                    'value' => 3,
                                ],
                                'maximum' => [
                                    'unit' => 'business_day',
                                    'value' => 5,
                                ],
                            ],
                        ],
                    ],
                ],
            ]);

            return response()->json(['id' => $session->id]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    // Handle successful payment
    public function success(Request $request, Product $product)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        Order::create([
            'user_id'          => $user->id,
            'product_id'       => $product->id,
            'payment_type'     => 'カード支払い',
            'shipping_postal_code' => session('purchase_address_' . $product->id)['postal_code'],
            'shipping_address'     => session('purchase_address_' . $product->id)['address'],
            'shipping_building'    => session('purchase_address_' . $product->id)['building'],
        ]);

        $product->is_sold = true;
        $product->save();

        // Delete address info in session
        session()->forget('purchase_address_' . $product->id);

        return redirect()->route('product.index');
    }

    // Handle convenience store payment
    public function store(PurchaseRequest $request, Product $product)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        Order::create([
            'user_id'          => $user->id,
            'product_id'       => $product->id,
            'payment_type'     => $request->payment,
            'shipping_postal_code' => $request->postal_code,
            'shipping_address'     => $request->address,
            'shipping_building'    => $request->building,
        ]);

        $product->is_sold = true;
        $product->save();

        // Delete address info in session
        session()->forget('purchase_address_' . $product->id);

        return redirect()->route('product.index');
    }
}
