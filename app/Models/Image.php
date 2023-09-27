<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'extension',
        'mime_type',
    ];

    // Attributes

    public function getPathAttribute(): string
    {
        return "app/images-uploads/{$this->id}.{$this->extension}";
    }

    public function getStoragePathAttribute(): string
    {
        return storage_path($this->path);
    }

    public function getUrlAttribute(): string
    {
        return route('web.image.show', $this->id);
    }

    // Relationships

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }
}
