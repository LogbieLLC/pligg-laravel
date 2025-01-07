<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Widget extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'version',
        'latest_version',
        'folder',
        'enabled',
        'column',
        'position',
        'display',
    ];

    protected $casts = [
        'version' => 'decimal:1',
        'latest_version' => 'decimal:1',
        'enabled' => 'boolean',
        'position' => 'integer',
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
