<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SnippetResource extends JsonResource
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
      'description' => $this->description,
      'is_public' => (bool) $this->is_public,
      'steps_count' => $this->steps->count(),
      'steps' => ['data' => StepResource::collection($this->steps)],
      'cover' => $this->when($this->cover(), new MediaResource($this->cover())),
      'author' => [
        'id' => $this->user->id,
        'name' => $this->user->name,
        'uuid' => $this->user->uuid
      ],
    ];
  }
}
