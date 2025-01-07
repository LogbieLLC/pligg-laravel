<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property string $type
 * @property string $formula
 * @property bool $enabled
 * @property string $title
 */
class Formula extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'formula',
        'enabled',
        'title'
    ];

    protected $casts = [
        'enabled' => 'boolean',
        'type' => 'string',
        'formula' => 'string'
    ];

    // Scopes
    public function scopeEnabled($query)
    {
        return $query->where('enabled', true);
    }

    public function scopeKarma($query)
    {
        return $query->where('type', 'karma');
    }

    public function scopeReport($query)
    {
        return $query->where('type', 'report');
    }

    // Methods
    public function isKarmaFormula(): bool
    {
        return $this->type === 'karma';
    }

    public function isReportFormula(): bool
    {
        return $this->type === 'report';
    }
}
