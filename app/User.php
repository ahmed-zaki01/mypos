<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable;


    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'img'
    ];


    protected $appends = ['img_path', 'full_name'];

    protected $hidden = [
        'password', 'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getFullNameAttribute()
    {
        $full_name = $this->first_name . ' ' . $this->last_name;
        return ucwords($full_name);
    }
    public function getFirstNameAttribute($value)
    {
        return ucfirst($value);
    } // end of get first name method

    public function getLastNameAttribute($value)
    {
        return ucfirst($value);
    } // end of get last name method

    public function getImgPathAttribute()
    {
        return asset('uploads/users/' . $this->img);
    }
} //end of user model
