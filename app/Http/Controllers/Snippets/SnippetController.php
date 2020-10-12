<?php

namespace App\Http\Controllers\Snippets;


use App\Models\Snippet;
use Illuminate\Http\Request;
use App\Scoping\Scopes\PublicScope;
use App\Http\Controllers\Controller;
use App\Http\Resources\SnippetResource;
use App\Scoping\Scopes\SearchTextScope;
use App\Scoping\Scopes\InStepsTitleScope;
use App\Http\Resources\SnippetLightResource;

class SnippetController extends Controller
{

  public function __construct()
  {
    //middleware
  }

  public function index(Request $request)
  {
    return SnippetLightResource::collection(
      Snippet::latest('updated_at')->withScopes($this->scopes())->paginate(3)
    );
  }

  public function show(Snippet $snippet, Request $request)
  {
    //authorize

    return new SnippetResource($snippet);
  }

  public function store(Request $request)
  {
    $snippet = $request->user()->snippets()->create();
    return new SnippetResource($snippet);
  }

  public function update(Snippet $snippet, Request $request)
  {
    //authorize

    //validate
    $this->validate($request, [
      'title' => 'nullable',
      'description' => 'nullable',
      'is_public' => 'boolean|nullable'
    ]);

    $snippet->update($request->only('title', 'description', 'is_public'));
  }

  public function destroy(Snippet $snippet, Request $request)
  {
    //authorize

    $snippet->delete();
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
