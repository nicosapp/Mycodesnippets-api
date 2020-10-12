<?php

namespace App\Http\Controllers\Users;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserWithSnippetsResource;

class UserController extends Controller
{
  public function show(User $user, Request $request)
  {
    //authorize
    return new UserWithSnippetsResource($user);
  }

  public function update(User $user, Request $request)
  {
    // authorize

    $this->validate($request, [
      'email' => 'required|email|unique:users,email,' . $user->id,
      'name' => 'required|max:191',
      'firstname' => 'max:190|nullable',
      'lastname' => 'max:190|nullable',
      'phone_number' => 'numeric|digits:10|nullable',
    ]);

    $user->update($request->only('email', 'name'));

    if ($user->infos()->exists()) {
      $user->infos()->update($request->only('firstname', 'lastname', 'description', 'phone_number'));
    }
  }
  public function changePassword(User $user, Request $request)
  {
    // authorize
    $this->validate($request, [
      'password' => 'required|min:6|confirmed',
      'password_confirmation' => 'required'
    ]);

    $user->update($request->only('password'));
  }
}
