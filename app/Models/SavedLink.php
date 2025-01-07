<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavedLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'link_id',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function link()
    {
        return $this->belongsTo(Link::class);
    }
}
