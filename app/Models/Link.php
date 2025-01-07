<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $author_id
 * @property string $status
 * @property string $randkey
 * @property int $category_id
 * @property string $lang_id
 * @property string $url
 * @property string $url_title
 * @property string $title
 * @property string $title_url
 * @property string $content
 * @property string $summary
 * @property string $tags
 * @property int|null $group_id
 * @property string|null $group_status
 * @property int $votes
 * @property int $comments
 * @property float $karma
 * @property int $reports
 * @property int $out_clicks
 * @property \DateTime $published_at
 * @property-read \App\Models\User $author
 * @property-read \App\Models\Category $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Category[] $additionalCategories
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $comments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Vote[] $votes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $tags
 * @property-read \App\Models\Group|null $group
 */
class Link extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_id',
        'status',
        'randkey',
        'category_id',
        'lang_id',
        'url',
        'url_title',
        'title',
        'title_url',
        'content',
        'summary',
        'tags',
        'group_id',
        'group_status',
        'votes',
        'comments',
        'karma',
        'reports',
        'out_clicks'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'votes' => 'integer',
        'comments' => 'integer',
        'karma' => 'decimal:2',
        'reports' => 'integer',
        'out_clicks' => 'integer',
        'author_id' => 'integer',
        'category_id' => 'integer',
        'group_id' => 'integer'
    ];

    // Relationships
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function additionalCategories()
    {
        return $this->belongsToMany(Category::class, 'additional_categories')->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function tags()
    {
        return $this->hasMany(Tag::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function sharedGroups()
    {
        return $this->belongsToMany(Group::class, 'group_shared')
                    ->withTimestamps();
    }

    public function savedByUsers()
    {
        return $this->belongsToMany(User::class, 'saved_links')->withTimestamps();
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }

    public function scopeByLang($query, $lang)
    {
        return $query->where('lang_id', $lang);
    }

    // Methods
    public function updateVoteCount(): void
    {
        $this->votes = $this->votes()->count();
        $this->save();
    }

    public function updateCommentCount(): void
    {
        $this->comments = $this->comments()->count();
        $this->save();
    }

    public function incrementOutClicks(): void
    {
        $this->increment('out_clicks');
    }
}
