<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Redirect extends Model
{
    use HasFactory;

    protected $fillable = [
        'old_path',
        'new_path',
    ];

    // Methods
    public function matches(string $path): bool
    {
        return $this->old_path === $path;
    }
}
