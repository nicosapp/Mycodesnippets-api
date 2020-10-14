<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'name' => $this->name,
      'url' => $this->getFullUrl(),
      'thumbnail_url' => $this->when($this->getUrl('thumbnail'), $this->getUrl('thumbnail')),
      'mime_type' => $this->mime_type,
      'created_at' => $this->created_at,
      'size' => $this->size,
      'readableSize' => $this->human_readable_size,
    ];
  }
}
