<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property string $name
 * @property string $folder
 * @property float $version
 * @property float $latest_version
 * @property bool $enabled
 * @property string|null $homepage_url
 * @property string|null $requires
 * @property string|null $description
 * @property string|null $created_by
 * @property string|null $column
 * @property int|null $position
 * @property string|null $display
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 */
class Widget extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'folder',
        'version',
        'latest_version',
        'enabled',
        'homepage_url',
        'requires',
        'description',
        'created_by',
        'column',
        'position',
        'display',
    ];

    protected $attributes = [
        'version' => 1.0,
        'latest_version' => 1.0,
        'enabled' => false,
    ];

    protected $casts = [
        'enabled' => 'boolean',
        'version' => 'decimal:1',
        'latest_version' => 'decimal:1',
        'position' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Scopes
    public function scopeEnabled($query)
    {
        return $query->where('enabled', true);
    }

    public function scopeByColumn($query, $column)
    {
        return $query->where('column', $column);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('position');
    }

    // Methods
    public function hasUpdate(): bool
    {
        return $this->latest_version > $this->version;
    }

    public function getPath(): string
    {
        return base_path('widgets/' . $this->folder);
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }
}
