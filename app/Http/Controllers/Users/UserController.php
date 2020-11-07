<?php

namespace App\Http\Controllers\Users;

use App\Models\User;
use App\Media\FileSize;
use App\Models\Snippet;
use App\Media\MimeTypes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Resources\MediaResource;
use App\Http\Resources\SnippetResource;

class UserController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:sanctum');
  }

  public function show(User $user, Request $request)
  {
    //authorize
    //need auth
    return new UserResource($user);
  }

  public function update(User $user, Request $request)
  {
    // authorize
    $this->authorize('update', $user);

    $this->validate($request, [
      'email' => 'required|email|unique:users,email,' . $user->id,
      'name' => 'required|max:191',
      'firstname' => 'max:190|nullable',
      'lastname' => 'max:190|nullable',
      'phone_number' => 'numeric|digits:10|nullable',
    ]);

    $user->update($request->only('email', 'name'));

    if ($user->infos()->exists()) {
      $user->infos()->update($request->only('firstname', 'lastname', 'phone_number'));
    }
  }
  public function updateProfile(User $user, Request $request)
  {
    // authorize
    $this->authorize('update', $user);

    $this->validate($request, [
      'name' => 'required|min:6',
      'description' => 'nullable'
    ]);

    $user->update($request->only('name'));
    if ($user->infos()->exists()) {
      $user->infos()->update($request->only('description'));
    }
  }

  public function updatePassword(User $user, Request $request)
  {
    // authorize
    $this->authorize('update', $user);

    $this->validate($request, [
      'password' => 'required|min:6|confirmed',
      'password_confirmation' => 'required'
    ]);

    $user->update($request->only('password'));
  }

  public function avatar(User $user, Request $request)
  {
    // authorize
    $this->authorize('update', $user);

    $this->validate($request, [
      'media.*' => 'required|file|max:' . FileSize::max_file_size()['kb'] . '|mimetypes:' . implode(',', MimeTypes::$image)
    ]);
    $user->clearMediaCollection(User::$mediaCollectionName);
    $media = $user->addMedia($request->file('media')[0])->setName('avatar')->toMediaCollection(User::$mediaCollectionName);

    return new MediaResource($media);
  }

  public function snippets(User $user, Request $request)
  {
    //authorization by auth

    return SnippetResource::collection(Snippet::where('user_id', $user->id)->public()->latest('updated_at')->paginate(3));
  }
}
