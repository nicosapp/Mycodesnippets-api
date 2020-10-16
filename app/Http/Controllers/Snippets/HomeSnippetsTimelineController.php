<?php

namespace App\Http\Controllers\Snippets;

use App\Models\Snippet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\SnippetLightResource;

class HomeSnippetsTimelineController extends Controller
{

  public function __invoke(Request $request)
  {
    if (Auth::check())
      return SnippetLightResource::collection(
        Snippet::where('user_id', $request->user()->id)->orWhere('is_public', true)->latest('updated_at')->paginate(Snippet::$pagination)
      );
    else {
      return SnippetLightResource::collection(
        Snippet::where('is_public', true)->latest('updated_at')->paginate(Snippet::$pagination)
      );
    }
  }
}
