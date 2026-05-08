<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderStatusLogs extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'user_id',
        'old_status',
        'new_status',
        'comment'
    ];
}
