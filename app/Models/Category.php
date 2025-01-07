<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int|null $parent_id
 * @property string $name
 * @property string $safe_name
 * @property int $rgt
 * @property int $lft
 * @property bool $enabled
 * @property int $order
 * @property string $description
 * @property string $keywords
 * @property string $author_level
 * @property int|null $author_group
 * @property int $votes
 * @property float $karma
 * @property string $lang
 */
class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'lang',
        'parent_id',
        'name',
        'safe_name',
        'rgt',
        'lft',
        'enabled',
        'order',
        'description',
        'keywords',
        'author_level',
        'author_group',
        'votes',
        'karma',
    ];

    protected $casts = [
        'enabled' => 'boolean',
        'order' => 'integer',
        'rgt' => 'integer',
        'lft' => 'integer',
    ];

    // Relationships
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function links()
    {
        return $this->hasMany(Link::class);
    }

    public function additionalLinks()
    {
        return $this->belongsToMany(Link::class, 'additional_categories')->withTimestamps();
    }

    // Scopes
    public function scopeEnabled($query)
    {
        return $query->where('enabled', true);
    }

    public function scopeByLang($query, $lang)
    {
        return $query->where('lang', $lang);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    // Methods
    public function isRoot(): bool
    {
        return $this->parent_id === 0;
    }

    public function hasChildren(): bool
    {
        return $this->children()->count() > 0;
    }

    public function getFullPath(): string
    {
        $path = [$this->name];
        $category = $this;

        while ($category->parent_id !== 0) {
            $category = $category->parent;
            array_unshift($path, $category->name);
        }

        return implode(' / ', $path);
    }
}
