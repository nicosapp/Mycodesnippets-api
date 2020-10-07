<?php

namespace App\Http\Controllers\Snippets;

use App\Models\Snippet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SnippetResource;

class SnippetController extends Controller
{

  public function __construct()
  {
    //middleware
  }

  public function index()
  {
    dd('test');
  }

  public function show(Snippet $snippet, Request $request)
  {
    //authorize

    return new SnippetResource($snippet);
  }

  public function store(Request $request)
  {
    $snippet = Snippet::create([
      'user_id' => 1,
    ]);
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
