<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GroupShared extends Model
{
    use HasFactory;

    protected $fillable = [
        'link_id',
        'group_id',
        'user_id',
    ];

    // Relationships
    public function link()
    {
        return $this->belongsTo(Link::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
