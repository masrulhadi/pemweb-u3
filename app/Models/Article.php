<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'slug', 'body', 'image'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::get(
            fn () => $this->image
                ?: 'https://picsum.photos/seed/article-' . $this->id . '/800/400'
        );
    }
}
