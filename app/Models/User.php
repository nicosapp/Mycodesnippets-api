<?php

namespace App\Models;

use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
  use HasFactory, Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name',
    'email',
    'password',
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

  public static function boot()
  {
    parent::boot();

    static::created(function (User $user) {
      $user->infos()->create();
    });
  }

  public function setPasswordAttribute($password)
  {
    if (trim($password) === '') {
      return;
    }
    $this->attributes['password'] = Hash::make($password);
  }

  public function snippets()
  {
    return $this->hasMany(Snippet::class);
  }

  public function infos()
  {
    return $this->hasOne(UserInfo::class);
  }
}
