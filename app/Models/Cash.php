<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cash extends Model
{
    protected $table = 'cash';
    protected $guarded = [];

// Di model Transaction
public function profits()
{
    return $this->hasMany(Profit::class, 'transaction_id');
}
public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

public function purchases()
{
    return $this->hasMany(Purchase::class, 'cash_id');
}

public function orders()
{
    return $this->hasMany(Order::class, 'cash_id');
}


}
