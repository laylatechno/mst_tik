<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    protected $table = 'blog_categories';
    protected $guarded = [];

    // Model BlogCategory
    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }
}
