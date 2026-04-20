<?php

namespace App\Models;

use App\enum\buyer\BuyerTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BuyerProfile extends Model
{
    protected $fillable = [
        'user_id',
        'company_name',
        'buyer_type',
        'total_orders',
    ];

    protected $casts = [
        'buyer_type' => BuyerTypeEnum::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
