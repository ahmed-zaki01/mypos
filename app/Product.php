<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Product extends Model
{
    use Translatable;

    protected $guarded = ['id'];
    protected $appends = ['img_path', 'profit_percent'];
    public $translatedAttributes = ['name', 'desc'];

    public function cat()
    {
        return $this->belongsTo(Cat::class);
    } // end of cat relation

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    } // end of order relation

    public function getImgPathAttribute()
    {
        return asset('uploads/products/' . $this->img);
    } // end of get image path method


    public function getProfitPercentAttribute()
    {
        $profit = $this->sell_price - $this->purchase_price;
        $profit_percent = ($profit * 100) / $this->purchase_price;
        return number_format($profit_percent, 2);
    } // end of get profit percent method
}
