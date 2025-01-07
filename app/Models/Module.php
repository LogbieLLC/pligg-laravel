<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Module extends Model
{
    protected $fillable = [
        'name',
        'folder',
        'version',
        'latest_version',
        'enabled',
        'weight'
    ];

    protected $casts = [
        'enabled' => 'boolean',
        'weight' => 'integer',
        'version' => 'string',
        'latest_version' => 'string'
    ];
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
