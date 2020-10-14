<?php

namespace App\Scoping\Scopes;

use Illuminate\Database\Eloquent\Builder;

class PublicScope
{
  public function apply(Builder $builder, $value)
  {
    if ($value)
      return $builder->where('is_public', $value);
    // else
    //   return $builder->where('user_id', $request->user->id);
  }
}
