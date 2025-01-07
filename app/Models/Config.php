<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property string $var_id
 * @property string $var_page
 * @property string $var_name
 * @property string $var_value
 * @property string $var_defaultvalue
 * @property string $var_optiontext
 * @property string $var_title
 * @property string $var_desc
 * @property string $var_method
 * @property bool $var_enclosein
 */
class Config extends Model
{
    use HasFactory;

    protected $primaryKey = 'var_id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'var_id',
        'var_page',
        'var_name',
        'var_value',
        'var_defaultvalue',
        'var_optiontext',
        'var_title',
        'var_desc',
        'var_method',
        'var_enclosein',
    ];

    protected $casts = [
        'var_enclosein' => 'boolean',
    ];

    // Scopes
    public function scopeByPage($query, $page)
    {
        return $query->where('var_page', $page);
    }

    // Methods
    public function getValue(): mixed
    {
        return $this->var_value ?? $this->var_defaultvalue;
    }

    public function resetToDefault(): void
    {
        $this->var_value = $this->var_defaultvalue;
        $this->save();
    }
}
