<?php

namespace App\Models;

use App\Scoping\Scoper;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use App\Models\Traits\CanBeScoped;
use App\Models\Traits\WithMediaConversion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\File;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Snippet extends Model implements HasMedia
{
  use HasFactory, CanBeScoped, InteractsWithMedia, WithMediaConversion;

  public static $mediaCollectionName = 'snippets';
  public static $pagination = 6;

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

  public function cover()
  {
    return $this->getMedia(self::$mediaCollectionName)->first();
  }

  public function scopePublic(Builder $builder)
  {
    return $builder->where('is_public', true);
  }

  public function isPublic()
  {
    return $this->is_public;
  }

  public function registerMediaConversions(?Media $media = null): void
  {
    $this->thumbnail();
  }
}
