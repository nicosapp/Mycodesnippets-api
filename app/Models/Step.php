<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Step extends Model
{
  use HasFactory;

  protected $fillable = [
    'uuid',
    'user_id',
    'title',
    'code',
    'body',
    'order',
    'language'
  ];

  public function getRouteKeyName()
  {
    return 'uuid';
  }

  public static function boot()
  {
    parent::boot();

    static::creating(function (Step $step) {
      $step->uuid = Str::uuid();
    });
  }

  public function snippet()
  {
    return $this->belongsTo(Snippet::class);
  }

  public function afterOrder()
  {
    $adjacent = self::where('order', '>', $this->order)
      ->orderBy('order', 'asc')
      ->first();
    if (!$adjacent) {
      dd('no');
    }
    return ($this->order + $adjacent->order);
  }
}
