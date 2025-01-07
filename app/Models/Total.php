<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Total extends Model
{
    use HasFactory;

    protected $primaryKey = 'name';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'total',
    ];

    protected $casts = [
        'total' => 'integer',
    ];

    // Methods
    public function increment($column = 'total', $amount = 1, array $extra = []): int
    {
        return parent::increment($column, $amount, $extra);
    }

    public function decrement($column = 'total', $amount = 1, array $extra = []): int
    {
        return parent::decrement($column, $amount, $extra);
    }
}
