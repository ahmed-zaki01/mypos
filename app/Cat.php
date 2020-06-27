<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Cat extends Model
{
    use Translatable;

    public $translatedAttributes = ['name'];
    protected $guarded = ['id'];

    public function cat_translations()
    {
        return $this->hasMany('App\CatTranslation');
    }
}
