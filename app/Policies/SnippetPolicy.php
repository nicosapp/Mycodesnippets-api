<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Snippet;
use Illuminate\Auth\Access\HandlesAuthorization;

class SnippetPolicy
{
  use HandlesAuthorization;

  /**
   * Create a new policy instance.
   *
   * @return void
   */
  public function show(?User $user, Snippet $snippet)
  {
    if ($snippet->isPublic()) {
      return true;
    }
    return optional($user)->id === $snippet->user_id;
  }

  public function update(User $user, Snippet $snippet)
  {
    return $user->id === $snippet->user_id;
  }

  public function store(User $user, Snippet $snippet)
  {
    return $user->id === $snippet->user_id;
  }

  public function destroy(User $user, Snippet $snippet)
  {
    return $user->id === $snippet->user_id;
  }
}
