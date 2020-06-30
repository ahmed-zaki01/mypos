<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Cat extends Model
{
    use Translatable;

    protected $guarded = ['id'];
    public $translatedAttributes = ['name'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
