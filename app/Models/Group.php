<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'creator_id',
        'status',
        'members_count',
        'safename',
        'name',
        'description',
        'privacy',
        'avatar',
        'vote_to_publish',
        'field1',
        'field2',
        'field3',
        'field4',
        'field5',
        'field6',
        'notify_email',
    ];

    protected $casts = [
        'members_count' => 'integer',
        'vote_to_publish' => 'integer',
        'notify_email' => 'boolean',
    ];

    // Relationships
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'group_members')
                    ->withPivot('role', 'status')
                    ->withTimestamps();
    }

    public function links()
    {
        return $this->hasMany(Link::class);
    }

    public function sharedLinks()
    {
        return $this->belongsToMany(Link::class, 'group_shared')
                    ->withTimestamps();
    }

    // Scopes
    public function scopeEnabled($query)
    {
        return $query->where('status', 'enable');
    }

    public function scopePublic($query)
    {
        return $query->where('privacy', 'public');
    }

    // Methods
    public function updateMemberCount(): void
    {
        $this->members_count = $this->members()
            ->wherePivot('status', 'active')
            ->count();
        $this->save();
    }

    public function isPublic(): bool
    {
        return $this->privacy === 'public';
    }

    public function isPrivate(): bool
    {
        return $this->privacy === 'private';
    }

    public function isRestricted(): bool
    {
        return $this->privacy === 'restricted';
    }
}
