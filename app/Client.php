<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $guarded = ['id'];
    protected $casts = ['phone' => 'array'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    } // end of orders

    public function getNameAttribute($value)
    {
        return ucwords($value);
    } // end of get uppercase name attribute
}
