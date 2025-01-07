<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vote extends Model
{
    protected $fillable = [
        'user_id',
        'voteable_id',
        'voteable_type',
        'value',
        'karma'
    ];

    protected $casts = [
        'value' => 'integer',
        'karma' => 'decimal:2'
    ];
    use HasFactory;

    protected $fillable = [
        'type',
        'link_id',
        'user_id',
        'value',
        'karma',
        'ip',
    ];

    protected $casts = [
        'value' => 'integer',
        'karma' => 'integer',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function link()
    {
        return $this->belongsTo(Link::class);
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }

    // Scopes
    public function scopeForLinks($query)
    {
        return $query->where('type', 'links');
    }

    public function scopeForComments($query)
    {
        return $query->where('type', 'comments');
    }

    public function scopeByIp($query, $ip)
    {
        return $query->where('ip', $ip);
    }

    // Methods
    public function isPositive(): bool
    {
        return $this->value > 0;
    }

    public function isNegative(): bool
    {
        return $this->value < 0;
    }

    public function calculateKarma(): float
    {
        // This will be replaced by KarmaService logic
        return $this->value * ($this->user->karma / 100);
    }
}
