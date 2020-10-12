<?php

namespace App\Scoping\Scopes;

use Illuminate\Database\Eloquent\Builder;

class SearchTextScope
{
  public function apply(Builder $builder, $value)
  {
    return $builder->where("title", "LIKE", "%{$value}%");
  }
}
