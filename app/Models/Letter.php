<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Letter extends Model
{
    protected $table = 'letters';
    protected $guarded = [];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id'); // sesuaikan dengan nama kolom di tabel
    }

    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id'); // sesuaikan dengan nama kolom di tabel
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
