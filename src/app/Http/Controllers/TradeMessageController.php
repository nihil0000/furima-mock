<?php

namespace App\Http\Controllers;

use App\Http\Requests\TradeMessageRequest;
use App\Models\Trade;
use App\Models\TradeMessage;

class TradeMessageController extends Controller
{
    public function store(TradeMessageRequest $request, Trade $trade)
    {
        $data = [
            'trade_id' => $trade->id,
            'user_id' => auth()->id(),
            'message' => $request->message,
        ];

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('trade_images', 'public');
            $data['image_path'] = $path;
        }

        TradeMessage::create($data);

        return redirect()->route('trade.show', $trade->id);
    }

    public function update(TradeMessageRequest $request, TradeMessage $message)
    {
        $this->authorize('update', $message);
        $message->message = $request->message;
        $message->save();

        return redirect()->route('trade.show', $message->trade_id);
    }

    public function destroy(TradeMessage $message)
    {
        $this->authorize('delete', $message);
        $tradeId = $message->trade_id;
        $message->delete();

        return redirect()->route('trade.show', $tradeId);
    }
}
