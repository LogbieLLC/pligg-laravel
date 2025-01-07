<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'votes' => 'integer',
        'reports' => 'integer',
        'comments' => 'integer',
        'karma' => 'decimal:2',
        'out_clicks' => 'integer',
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
