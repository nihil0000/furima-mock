<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'buyer_id',
        'seller_id',
        'status',
        'completed_at',
        'buyer_rated_at',
        'seller_rated_at'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function tradeMessages()
    {
        return $this->hasMany(TradeMessage::class);
    }
}
