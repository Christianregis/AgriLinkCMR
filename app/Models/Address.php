<?php

namespace App\Models;

use App\enum\address\AddressType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    protected $fillable = [
        'label',
        'type',
        'recipient_name',
        'street',
        'city',
        'region',
        'phone',
        'instructions',
        'user_id',
    ];

    protected $casts = [
        'type' => AddressType::class,
    ];

    public function user() : BelongsTo{
        return $this->belongsTo(User::class, 'user_id');
    }
}
