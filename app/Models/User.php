<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'login',
        'level',
        'name',
        'email',
        'password',
        'karma',
        'url',
        'facebook',
        'twitter',
        'linkedin',
        'googleplus',
        'skype',
        'pinterest',
        'public_email',
        'avatar_source',
        'location',
        'occupation',
        'categories',
        'language',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'reset_code',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login' => 'datetime',
        'last_reset_request' => 'datetime',
        'karma' => 'decimal:2',
        'enabled' => 'boolean',
        'password' => 'hashed',
        'level' => 'string',
    ];

    // Relationships
    public function links()
    {
        return $this->hasMany(Link::class, 'author_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function savedLinks()
    {
        return $this->belongsToMany(Link::class, 'saved_links')->withTimestamps();
    }

    public function friends()
    {
        return $this->belongsToMany(User::class, 'friends', 'from_user_id', 'to_user_id')->withTimestamps();
    }

    public function friendOf()
    {
        return $this->belongsToMany(User::class, 'friends', 'to_user_id', 'from_user_id')->withTimestamps();
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_members')
                    ->withPivot('role', 'status')
                    ->withTimestamps();
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'from_user_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'to_user_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('enabled', true);
    }

    public function scopeAdmins($query)
    {
        return $query->where('level', 'admin');
    }

    public function scopeModerators($query)
    {
        return $query->where('level', 'moderator');
    }

    // Methods
    public function isAdmin(): bool
    {
        return $this->level === 'admin';
    }

    public function isModerator(): bool
    {
        return $this->level === 'moderator';
    }

    public function canModerate(): bool
    {
        return in_array($this->level, ['admin', 'moderator']);
    }

    public function updateKarma(float $amount): void
    {
        $this->karma += $amount;
        $this->save();
    }

    public function canVote(): bool
    {
        return $this->enabled && $this->karma >= config('pligg.min_karma_vote', 0);
    }

    public function canSubmitLinks(): bool
    {
        return $this->enabled && $this->karma >= config('pligg.min_karma_submit', 0);
    }

    public function canComment(): bool
    {
        return $this->enabled && $this->karma >= config('pligg.min_karma_comment', 0);
    }

    public function updateLastLogin(): void
    {
        $this->last_login = now();
        $this->save();
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function disable(): void
    {
        $this->enabled = false;
        $this->save();
    }

    public function enable(): void
    {
        $this->enabled = true;
        $this->save();
    }
}
