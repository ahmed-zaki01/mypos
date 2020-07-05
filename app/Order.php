<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = ['id'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    } // end of client

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity');
    } // end of product relation
}
