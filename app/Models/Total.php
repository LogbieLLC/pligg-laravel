<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    public function increment(int $amount = 1): void
    {
        $this->total += $amount;
        $this->save();
    }

    public function decrement(int $amount = 1): void
    {
        $this->total -= $amount;
        $this->save();
    }
}
