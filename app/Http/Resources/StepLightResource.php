<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StepLightResource extends JsonResource
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
      'uuid' => $this->uuid,
      'title' => $this->title,
      'code' => $this->code,
      'order' => $this->order,
      'language' => $this->language
    ];
  }
}
