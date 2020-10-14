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
    //middleware
  }

  public function index(Request $request)
  {
    return SnippetLightResource::collection(
      Snippet::withScopes($this->scopes())->latest('updated_at')->paginate($this->pagination)
    );
  }

  public function home(Request $request)
  {
    // return $request->user()->id;
    return SnippetLightResource::collection(
      Snippet::where('user_id', $request->user()->id)->orWhere('is_public', true)->latest('updated_at')->paginate($this->pagination)
    );
  }

  public function show(Snippet $snippet, Request $request)
  {
    //authorize
    $snippet->increment('viewed', 1);
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

  public function cover(Snippet $snippet, Request $request)
  {
    //authorize

    $this->validate($request, [
      'media.*' => 'required|file|max:' . FileSize::max_file_size()['kb'] . '|mimetypes:' . implode(',', MimeTypes::$image)
    ]);
    $snippet->clearMediaCollection(Snippet::$mediaCollectionName);
    $media = $snippet->addMedia($request->file('media')[0])->setName('cover')->toMediaCollection(Snippet::$mediaCollectionName);

    return new MediaResource($media);
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
