<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property string $old_path
 * @property string $new_path
 * @property int $hits
 */
class Redirect extends Model
{
    use HasFactory;

    protected $fillable = [
        'old_path',
        'new_path',
        'hits',
    ];

    protected $casts = [
        'old_path' => 'string',
        'new_path' => 'string',
        'hits' => 'integer',
    ];

    // Methods
    public function matches(string $path): bool
    {
        return $this->old_path === $path;
    }
}
