<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Formula extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'enabled',
        'title',
        'formula',
    ];

    protected $casts = [
        'enabled' => 'boolean',
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
