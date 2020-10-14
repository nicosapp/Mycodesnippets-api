<?php

namespace App\Http\Controllers\Snippets;

use App\Models\Snippet;
use Illuminate\Http\Request;
use App\Scoping\Scopes\PublicScope;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Scoping\Scopes\SearchTextScope;
use App\Scoping\Scopes\InStepsTitleScope;
use App\Http\Resources\SnippetLightResource;

class SearchSnippetsController extends Controller
{
  protected $pagination = 6;

  public function __invoke(Request $request)
  {
    if (Auth::check()) {
      return SnippetLightResource::collection(
        Snippet::withScopes($this->scopes())->latest('updated_at')->paginate($this->pagination)
      );
    }
    return SnippetLightResource::collection(
      Snippet::withScopes($this->scopes())->orWhere('is_public', true)->latest('updated_at')->paginate($this->pagination)
    );
  }

  public function scopes()
  {
    return [
      'searchText' => new SearchTextScope(),
      'isPublic' => new PublicScope(),
      'inStepsTitle' => new InStepsTitleScope(),
    ];
  }
}
