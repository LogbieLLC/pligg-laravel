<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    protected $fillable = [
        'user_id',
        'link_id',
        'parent_id',
        'content',
        'votes',
        'karma',
        'status',
        'reported'
    ];

    protected $casts = [
        'votes' => 'integer',
        'karma' => 'decimal:2',
        'reported' => 'boolean',
        'parent_id' => 'integer'
    ];
    use HasFactory;

    protected $fillable = [
        'randkey',
        'parent_id',
        'link_id',
        'user_id',
        'content',
        'status',
    ];

    protected $casts = [
        'karma' => 'decimal:2',
        'votes' => 'integer',
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

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function votes()
    {
        return $this->hasMany(Vote::class)->where('type', 'comments');
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeModerated($query)
    {
        return $query->where('status', 'moderated');
    }

    public function scopeTopLevel($query)
    {
        return $query->whereNull('parent_id');
    }

    // Methods
    public function updateVoteCount(): void
    {
        $this->votes = $this->votes()->count();
        $this->save();
    }

    public function isReply(): bool
    {
        return !is_null($this->parent_id);
    }

    public function hasReplies(): bool
    {
        return $this->replies()->count() > 0;
    }

    public function updateKarma(float $amount): void
    {
        $this->karma += $amount;
        $this->save();
    }
}
