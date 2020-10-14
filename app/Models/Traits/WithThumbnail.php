<?php

namespace App\Models\Traits;

use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

trait WithThumbnail
{
  use InteractsWithMedia;

  public function thumbnail(Media $media = null): void
  {
    $this->addMediaConversion('thumbnail')
      ->crop('crop-center', 50, 50)
      ->nonQueued();
  }
  public function preview()
  {
    $this->addMediaConversion('preview')
      ->crop('crop-center', 30, 30);
  }
  public function prevSeen()
  {
    $this->addMediaConversion('prev_seen')
      ->fit('crop', 146, 122);
  }
  public function list()
  {
    $this->addMediaConversion('list')
      ->fit('crop', 528, 528);
  }
  public function table()
  {
    $this->addMediaConversion('table')
      ->fit('crop', 354, 354);
  }
  public function preset()
  {
    $this->addMediaConversion('preset')
      ->fit('crop', 146, 146);
  }
  public function big()
  {
    $this->addMediaConversion('big')
      ->fit('fill', 1248, 1248);
  }
}
