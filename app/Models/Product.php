<?php

namespace App\Models;

use App\enum\product\ProductStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'title',
        'slug',
        'description',
        'quantity',
        'unit',
        'price',
        'min_order_qte',
        'price_negotiable',
        'harvest_date',
        'expire_at',
        'status',

        'user_id',
        'category_id',
        'region_id',
        'views_count'
    ];

    protected $casts = [
        'status' => ProductStatus::class
    ];

    public function productImages(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(user::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function orderItems() : HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
