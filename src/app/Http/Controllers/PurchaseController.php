<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\ShipAddressRequest;
use App\Models\Product;
use App\Models\Order;

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

        return view('purchase.checkout', compact('address', 'product'));
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


    // Purchase
    public function store(PurchaseRequest $request, Product $product)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $address = session('purchase_address');

        Order::create([
            'user_id'          => $user->id,
            'product_id'       => $product->id,
            'payment_type'     => $request->payment,
            'shipping_postal_code' => $address['postal_code'],
            'shipping_address'     => $address['address'],
            'shipping_building'    => $address['building'],
        ]);

        $product->is_sold = true;
        $product->save();

        // Delete address info in session
        session()->forget('purchase_address_' . $product->id);

        return redirect()->route('product.index');
    }
}
