<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'account',
        'phone',
        'image'
    ];

    protected $appends = [
        'code_user',
        'role_status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles(){
        return $this->hasOne(Role::class);
    }

    public function getImageAttribute($value) {
        $path = 'storage/user/' . $value;
        return $value ? asset($path) : 'https://www.riobeauty.co.uk/images/product_image_not_found.gif';
    }

    public function getCodeUserAttribute($value) {
        return $this->roles->user_code;
    }

    public function getRoleStatusAttribute($value) {
        return $this->roles->status;
    }
    
}
