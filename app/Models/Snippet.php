<?php

namespace App\Models;

use App\Scoping\Scoper;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Snippet extends Model
{
  use HasFactory;

  protected $fillable = [
    'uuid',
    'user_id',
    'title',
    'description',
    'is_public'
  ];

  public function getRouteKeyName()
  {
    return 'uuid';
  }

  public static function boot()
  {
    parent::boot();

    static::created(function (Snippet $snippet) {
      $snippet->steps()->create([
        'order' => 1,
      ]);
    });
    static::creating(function (Snippet $snippet) {
      $snippet->uuid = Str::uuid();
    });
  }

  public function steps()
  {
    return $this->hasMany(Step::class)->orderBy('order', 'asc');
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  //Scope with scope
  public function scopeWithScopes(Builder $builder, $scopes = [])
  {
    return (new Scoper(request()))->apply($builder, $scopes);
  }
}
