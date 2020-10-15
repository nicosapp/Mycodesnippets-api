<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class SignOutController extends Controller
{
  use AuthenticatesUsers;

  public function __construct()
  {
    $this->middleware('guest')->except('logout');
  }

  /**
   * Undocumented function
   *
   * @return void
   */
  public function __invoke()
  {
    Auth::logout();
  }
}
