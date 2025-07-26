<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddressRequest;
use App\Models\Address;
use App\Models\Trade;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        $user = auth()->user();

        $trades = Trade::where(function($query) use ($user) {
            $query->where('buyer_id', $user->id)
                  ->orWhere('seller_id', $user->id);
        })
        ->where('status', 'trading')
            ->with('product')
            ->with(['tradeMessages' => function($q) { $q->latest(); }])
            ->get()
            ->sortByDesc(function($trade) {
                return optional($trade->tradeMessages->first())->created_at;
            })
            ->map(function($trade) use ($user) {
                $unreadCount = $trade->tradeMessages()
                    ->where('is_read', false)
                    ->where('user_id', '!=', $user->id)
                    ->count();
                $trade->unread_count = $unreadCount;
                return $trade;
            })
            ->values();

        $tradingCount = $trades->sum('unread_count');

        return view('profile.show', [
            'user' => $user,
            'tradingProducts' => $trades,
            'tradingCount' => $tradingCount,
        ]);
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
        $user->load('receivedRatings');

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
