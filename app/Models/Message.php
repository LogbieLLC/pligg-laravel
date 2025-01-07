<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property bool $read
 * @property \DateTime|null $read_at
 * @property string $title
 * @property string $body
 */
class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_user_id',
        'to_user_id',
        'title',
        'body',
        'read',
        'read_at',
    ];

    protected $casts = [
        'read' => 'boolean',
        'read_at' => 'datetime',
    ];

    // Relationships
    public function sender()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function recipient()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }

    // Scopes
    public function scopeUnread($query)
    {
        return $query->where('read', false);
    }

    public function scopeRead($query)
    {
        return $query->where('read', true);
    }

    // Methods
    public function markAsRead(): void
    {
        if (!$this->read) {
            $this->read = true;
            $this->read_at = now();
            $this->save();
        }
    }
}
