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
      $this->mergeWhen(
        $this->infos()->exists(),
        [
          'firstname' => $this->infos->firstname,
          'lastname' => $this->infos->lastname,
          'locale' => $this->infos->locale
        ]
      )
    ];
  }
}
