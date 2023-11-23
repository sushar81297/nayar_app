<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Post extends Authenticatable
{
    use Notifiable,HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'post_id',
        'message',
        'page_id',
        'comments',
        'likes',
        'image',
        'images',
        'created_time'
    ];

     /**
     * The attributes that should be cast.
     *
     * @var array

     */
    protected $casts = [
        'images' => 'array'
    ];

}
