<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'version',
        'latest_version',
        'folder',
        'enabled',
    ];

    protected $casts = [
        'version' => 'decimal:1',
        'latest_version' => 'decimal:1',
        'enabled' => 'boolean',
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
