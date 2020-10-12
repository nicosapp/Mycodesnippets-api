<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
  public function toArray($request)
  {
    return  [
      'id' => $this->id,
      'email' => $this->email,
      'name' => $this->name,
      'uuid' => $this->uuid,
      $this->mergeWhen(
        $this->infos()->exists(),
        [
          'firstname' => $this->infos->firstname,
          'lastname' => $this->infos->lastname,
          'description' => $this->infos->description,
          'locale' => $this->infos->locale
        ]
      )
    ];
  }
}
