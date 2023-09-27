<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

    // Relationships

    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }
}
