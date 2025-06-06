<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_name',
        'brand_name',
        'price',
        'description',
        'status',
        'image',
        'is_sold',
    ];

    public function user()
    {
        return $this->belongsTo((User::class));
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_category', 'product_id', 'category_id');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function trades()
    {
        return $this->hasMany(Trade::class);
    }

    // trades経由でtradeMessagesを取得
    public function tradeMessages()
    {
        return $this->hasManyThrough(
            \App\Models\TradeMessage::class, // 最終的に取得したいモデル
            \App\Models\Trade::class,        // 中間テーブル
            'product_id',                    // Tradeの外部キー（Productに対して）
            'trade_id',                      // TradeMessageの外部キー（Tradeに対して）
            'id',                            // Productのローカルキー
            'id'                             // Tradeのローカルキー
        );
    }

    // Scope a query to exclude products owned by a specific user
    public function scopeExcludeOwn($query, $userId)
    {
        return $query->where('user_id', '!=', $userId);
    }

    // Scope a query to search products by keyword in the product name
    public function scopeSearch($query, $keyword)
    {
        return $query->where('product_name', 'like', "%$keyword%");
    }
}
