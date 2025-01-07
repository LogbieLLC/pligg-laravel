<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $creator_id
 * @property string $status
 * @property int $members_count
 * @property string $safename
 * @property string $name
 * @property string $description
 * @property string $privacy
 * @property string|null $avatar
 * @property int $vote_to_publish
 * @property string|null $field1
 * @property string|null $field2
 * @property string|null $field3
 * @property string|null $field4
 * @property string|null $field5
 * @property string|null $field6
 * @property bool $notify_email
 */
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
        'creator_id' => 'integer'
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
