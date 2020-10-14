<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
  use HandlesAuthorization;

  /**
   * Create a new policy instance.
   *
   * @return void
   */
  public function show(?User $requester, User $user)
  {
    return 1;
  }

  public function update(User $requester, User $user)
  {
    return $user->id === $requester->id;
  }
}
