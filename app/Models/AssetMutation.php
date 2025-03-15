<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetMutation extends Model
{
    protected $table = 'asset_mutations';
    protected $guarded = [];

    // Relasi ke User (Penanggung Jawab)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke Asset (Aset terkait)
    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }

    // Relasi ke Room (Lokasi Lama)
    public function previousRoom()
    {
        return $this->belongsTo(Room::class, 'previous_room_id');
    }

    // Relasi ke Room (Lokasi Baru)
    public function newRoom()
    {
        return $this->belongsTo(Room::class, 'new_room_id');
    }
 
}
