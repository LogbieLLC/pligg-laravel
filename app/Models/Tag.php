<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'link_id',
        'lang',
        'words',
    ];

    // Relationships
    public function link()
    {
        return $this->belongsTo(Link::class);
    }

    // Scopes
    public function scopeByLang($query, $lang)
    {
        return $query->where('lang', $lang);
    }

    // Methods
    public function updateCache(): void
    {
        TagCache::query()->updateOrCreate(
            ['tag_words' => $this->words],
            ['count' => static::query()->where('words', $this->words)->count()]
        );
    }
}
