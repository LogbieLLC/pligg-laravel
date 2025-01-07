<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $count
 * @property string $ip
 * @property string $username
 * @property \DateTime|null $last_attempt
 */
class LoginAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'username',
        'ip',
        'count',
        'last_attempt',
    ];

    protected $casts = [
        'count' => 'integer',
        'last_attempt' => 'datetime',
    ];

    // Scopes
    public function scopeByIp($query, $ip)
    {
        return $query->where('ip', $ip);
    }

    public function scopeByUsername($query, $username)
    {
        return $query->where('username', $username);
    }

    public function scopeRecent($query, $minutes = 15)
    {
        return $query->where('created_at', '>=', now()->subMinutes($minutes));
    }

    // Methods
    public function incrementAttempts(): void
    {
        $this->increment('count');
    }

    public function resetAttempts(): void
    {
        $this->count = 0;
        $this->save();
    }

    public function hasExceededLimit(int $limit = 5): bool
    {
        return $this->count >= $limit;
    }
}
