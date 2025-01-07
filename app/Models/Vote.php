<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $user_id
 * @property int|null $voteable_id
 * @property string|null $voteable_type
 * @property int|null $link_id
 * @property string|null $type
 * @property int $value
 * @property float $karma
 * @property string|null $ip
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Link|null $link
 */
class Vote extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'voteable_id',
        'voteable_type',
        'type',
        'link_id',
        'value',
        'karma',
        'ip',
    ];

    protected $casts = [
        'value' => 'integer',
        'karma' => 'decimal:2',
        'user_id' => 'integer',
        'link_id' => 'integer',
        'voteable_id' => 'integer'
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
