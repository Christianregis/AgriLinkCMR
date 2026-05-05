<?php

namespace App\Models;

use App\enum\order\OrderEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

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
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function orderStatusLogs(): HasMany
    {
        return $this->hasMany(OrderStatusLogs::class);
    }

    // Scopes
    public function scopeWithFarmer($query, $farmer_id)
    {
        $query->where('farmer_id', $farmer_id);
    }

    public function scopeWithBuyer($query, $buyer_id)
    {
        $query->where('buyer_id', $buyer_id);
    }

    public function scopeWithStatusSuccess($query)
    {
        $query->where('status', OrderEnum::SUCCESS);
    }
    public function scopeWithStatusPending($query)
    {
        $query->where('status', OrderEnum::PENDING);
    }
    public function scopeWithStatusReady($query)
    {
        $query->where('status', OrderEnum::READY);
    }
    public function scopeWithStatusCancel($query)
    {
        $query->where('status', OrderEnum::CANCEL);
    }
}
