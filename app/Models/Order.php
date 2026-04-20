<?php

namespace App\Models;

use App\enum\order\OrderEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'buyer_id',
        'farmer_id',
        'status',
        'payment_method',
        'delivery_address',
        'total_amount',
        'notes'
    ];

    protected $casts = [
        'status' => OrderEnum::class,
    ];

    public function farmer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'farmer_id');
    }

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'farmer_id');
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function orderStatusLogs(): HasMany
    {
        return $this->hasMany(OrderStatusLogs::class);
    }
}
