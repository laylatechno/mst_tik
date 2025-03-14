<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetCategory extends Model
{
    protected $table = 'asset_categories';
    protected $guarded = [];

    // Model AssetCategory
    public function assets()
    {
        return $this->hasMany(Asset::class);
    }
}
