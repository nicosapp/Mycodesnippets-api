<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SignOutController extends Controller
{
  public function __construct()
  {
    $this->middleware(['auth:sanctum']);
  }
  /**
   * 
   */
  public function __invoke()
  {
    if (Auth::logout()) {
      return response(null, 204);
    }
  }
}
