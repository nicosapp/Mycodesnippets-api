<?php

namespace App\Http\Controllers\Snippets;

use App\Models\Snippet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SnippetResource;
use App\Http\Resources\SnippetLightResource;

class SnippetController extends Controller
{

  public function __construct()
  {
    //middleware
  }

  public function index(Request $request)
  {
    return SnippetLightResource::collection($request->user()->snippets()->get());
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
}
