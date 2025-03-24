<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddressRequest;
use App\Models\Address;

class ProfileController extends Controller
{
    public function show()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $user->load(['products', 'orders']);

        return view('profile.show', compact('user'));
    }

    public function edit()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $user->load('address');

        return view('profile.edit', compact('user'));
    }

    public function store(AddressRequest $request)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $user->load('address');

        // If a file is uploaded
        if ($request->hasFile('image')) {
            $file = $request->image;
            $filename = $file->getClientOriginalName(); // Get the original filename of the uploaded file
            $file->storeAs('public/images', $filename); // Store the uploaded file
            $user->update(['profile_image' => 'images/' . $filename]); // Update the file path in the database
        }

        $user->update([
            'name' => $request->name,
        ]);

        if ($user->address) {
            $user->address->update([
                'postal_code' => $request->postal_code,
                'address'     => $request->address,
                'building'    => $request->building,
            ]);
        } else {
            Address::create([
                'user_id' => $user->id,
                'postal_code' => $request->postal_code,
                'address'     => $request->address,
                'building'    => $request->building,
            ]);
        }

        return redirect()->route('product.index');
    }
}
