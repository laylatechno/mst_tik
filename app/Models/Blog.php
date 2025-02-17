<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table = 'blogs';
    protected $guarded = [];

    // Menentukan kolom foreign key yang benar, yaitu blog_category_id
    public function blog_category()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');  // Gunakan blog_category_id sebagai foreign key
    }
}
