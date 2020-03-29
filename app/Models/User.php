<?php

namespace App\Models;

use App\Models\Shapes\Circle;
use App\Models\Shapes\Rectangle;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'api_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * @return HasMany
     */
    public function worksheets(): HasMany
    {
        return $this->hasMany(Worksheet::class);
    }


    /**
     * @return HasMany
     */
    public function circles(): HasMany
    {
        return $this->hasMany(Circle::class);
    }


    /**
     * @return HasMany
     */
    public function rectangles(): HasMany
    {
        return $this->hasMany(Rectangle::class);
    }
}
