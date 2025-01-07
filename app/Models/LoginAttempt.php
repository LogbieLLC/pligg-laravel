<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'username',
        'ip',
        'count',
    ];

    protected $casts = [
        'count' => 'integer',
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
