<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        TagCache::updateOrCreate(
            ['tag_words' => $this->words],
            ['count' => Tag::where('words', $this->words)->count()]
        );
    }
}
