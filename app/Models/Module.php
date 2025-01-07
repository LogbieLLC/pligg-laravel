<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property string $name
 * @property string $folder
 * @property string $version
 * @property string $latest_version
 * @property bool $enabled
 * @property int $weight
 */
class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'folder',
        'version',
        'latest_version',
        'enabled',
        'weight',
    ];

    protected $casts = [
        'enabled' => 'boolean',
        'weight' => 'integer',
        'version' => 'decimal:1',
        'latest_version' => 'decimal:1',
    ];

    // Scopes
    public function scopeEnabled($query)
    {
        return $query->where('enabled', true);
    }

    // Methods
    public function hasUpdate(): bool
    {
        return $this->latest_version > $this->version;
    }

    public function getPath(): string
    {
        return base_path('modules/' . $this->folder);
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }
}
