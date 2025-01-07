<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdditionalCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'link_id',
        'category_id',
    ];

    public $timestamps = true;

    // Relationships
    public function link()
    {
        return $this->belongsTo(Link::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
