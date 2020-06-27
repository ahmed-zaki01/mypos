<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatTranslation extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['name'];

    public function Cat()
    {
        return $this->belongsTo('App\Cat');
    }
}
