<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TagCache extends Model
{
    use HasFactory;

    protected $primaryKey = 'tag_words';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'tag_words',
        'count',
    ];

    protected $casts = [
        'count' => 'integer',
    ];

    // Scopes
    public function scopePopular($query, $limit = 10)
    {
        return $query->orderBy('count', 'desc')->limit($limit);
    }

    // Methods
    public function incrementCount(): void
    {
        $this->increment('count');
    }

    public function decrementCount(): void
    {
        $this->decrement('count');
    }
}
