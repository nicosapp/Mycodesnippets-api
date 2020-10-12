<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserWithSnippetsResource extends UserResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
  public function toArray($request)
  {
    return array_merge(parent::toArray($request), [
      'snippets' => $this->snippets()->paginate(2)
    ]);
  }
}
