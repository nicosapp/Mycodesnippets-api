<?php

namespace App\Http\Controllers\Snippets;


use App\Media\FileSize;
use App\Models\Snippet;
use App\Media\MimeTypes;
use Illuminate\Http\Request;
use App\Scoping\Scopes\PublicScope;
use App\Http\Controllers\Controller;
use App\Http\Resources\MediaResource;
use App\Http\Resources\SnippetResource;
use App\Scoping\Scopes\SearchTextScope;
use App\Scoping\Scopes\InStepsTitleScope;
use App\Http\Resources\SnippetLightResource;

class SnippetController extends Controller
{
  protected $pagination = 3;

  public function __construct()
  {
    $this->middleware('auth:sanctum', ['except' => ['show', 'index']]);
  }

  public function show(Snippet $snippet, Request $request)
  {
    //authorization
    $this->authorize('show', $snippet);

    $snippet->increment('viewed', 1);
    return new SnippetResource($snippet);
  }

  public function store(Request $request)
  {
    //authorization by auth

    $snippet = $request->user()->snippets()->create();
    return new SnippetResource($snippet);
  }

  public function update(Snippet $snippet, Request $request)
  {
    //authorization
    $this->authorize('update', $snippet);

    //validate
    $this->validate($request, [
      'title' => 'nullable',
      'description' => 'nullable',
      'is_public' => 'boolean|nullable'
    ]);

    $snippet->update($request->only('title', 'description', 'is_public'));
  }

  public function cover(Snippet $snippet, Request $request)
  {
    //authorization
    $this->authorize('update', $snippet);

    //validation
    $this->validate($request, [
      'media.*' => 'required|file|max:' . FileSize::max_file_size()['kb'] . '|mimetypes:' . implode(',', MimeTypes::$image)
    ]);
    $snippet->clearMediaCollection(Snippet::$mediaCollectionName);
    $media = $snippet->addMedia($request->file('media')[0])->setName('cover')->toMediaCollection(Snippet::$mediaCollectionName);

    return new MediaResource($media);
  }

  public function destroy(Snippet $snippet, Request $request)
  {
    //authorization
    $this->authorize('destroy', $snippet);

    $snippet->delete();
  }

  public function titleAvailable(Request $request)
  {
    $this->validate($request, [
      'title' => 'string',
    ]);
    $available = true;
    if ($request->title)
      $available = !$request->user()->snippets()->where('title', $request->title)->exists();

    return response()->json([
      'data' => [
        'available' => $available
      ]
    ]);
  }
}
