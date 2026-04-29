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
        'price_negotiable',
        'harvest_date',
        'min_order_qty',
        'expires_at',
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

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // Scopes pour le trie
    public function scopeWithRelations($query)
    {
        return $query->with(['user', 'category', 'region']);
    }

    public function scopeFilterCategories($query, $categories)
    {
        if (!empty($categories)) {
            $query->whereIn('category_id', $categories);
        }
    }

    public function scopeFilterRegion($query, $region)
    {
        if ($region) {
            $query->where('region_id', $region);
        }
    }

    public function scopeFilterMaxPrice($query, $price)
    {
        if ($price) {
            $query->where('price', '<=', $price);
        }
    }

    public function scopeFilterMinRating($query, $rating)
    {
        if ($rating) {
            $query->whereHas('user.farmerProfile', function ($q) use ($rating) {
                $q->where('average_rating', '>=', $rating);
            });
        }
    }

    public function scopeSortBy($query, $sort)
    {
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;

            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;

            case 'latest':
            default:
                $query->latest();
                break;
        }
    }

    public function scopeAvaliable($query)
    {
        $query->where('status', ProductStatus::AVAILABLE);
    }
    public function scopeFindByUser($query, $user_id)
    {
        $query->where('user_id', $user_id);
    }

    public function scopeQuantityLow($query)
    {
        $query->where('quantity', '<=', 4);
    }
}
