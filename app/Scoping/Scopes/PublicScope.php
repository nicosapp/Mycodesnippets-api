<?php

namespace App\Scoping\Scopes;

use Illuminate\Database\Eloquent\Builder;

class PublicScope
{
  public function apply(Builder $builder, $value)
  {
    return $builder->where('is_public', $value);
  }
}
