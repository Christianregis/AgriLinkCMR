<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


class Message extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'conversation_id',
        'sender_id',
        'body',
        'attachment_path',
        'read_at'
    ];

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->fit(Fit::Crop, 300, 300)
            ->format('webp')
            ->quality(40)
            ->nonQueued();

        $this->addMediaConversion('message')
            ->width(800)
            ->height(800)
            ->format('webp')
            ->quality(60)
            ->nonQueued();

        $this->addMediaConversion('large')
            ->width(1200)
            ->height(1200)
            ->format('webp')
            ->quality(80)
            ->nonQueued();
    }
}
