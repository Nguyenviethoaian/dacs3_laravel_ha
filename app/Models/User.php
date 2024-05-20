<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = "users" ;
    protected $quarded=['id'];
    protected $hidden=[
        'password',
    ];
    protected $fillable = [
        'name',
        'email', 
        'password',
    ];
    const USER_TOKEN ="userToken";
    public function chats() :HasMany{
        return $this->hasMany(Chat::class, 'created_by' );
    }
}
