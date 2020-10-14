<?php

namespace App\Http\Controllers\Snippets;

use App\Models\Step;
use App\Models\Snippet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\SnippetResource;
use App\Http\Resources\StepResource;

class StepController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:sanctum', ['except' => ['show']]);
  }

  public function show(Step $step, Request $request)
  {
    //authorize
    $this->authorize('show', $step->snippet);

    return new StepResource($step);
  }

  public function store(Snippet $snippet, Request $request)
  {
    //authorize
    $this->authorize('store', $snippet);

    $step = $snippet->steps()->create(array_merge(
      $request->only('title', 'body'),
      [
        'order' => $this->getOrder($snippet, $request)
      ]
    ));
    // ->{($request->before ? 'before' : 'after') . 'Order'}()

    return new StepResource($step);
  }

  public function getOrder(Snippet $snippet, Request $request)
  {
    $order = Step::where('uuid', $request->after)
      ->first()->order;

    $snippet->steps()->where('order', '>', $order)->update([
      'order' => DB::raw('`order` + 1')
    ]);
    return $order + 1;
  }

  public function update(Step $step, Request $request)
  {
    //authorize
    $this->authorize('update', $step->snippet);

    //validate
    $this->validate($request, [
      'title' => 'nullable',
      'body' => 'nullable',
      'order' => 'integer|nullable'
    ]);
    $step->update($request->only('title', 'body', 'order'));
  }

  public function destroy(Snippet $snippet, Step $step, Request $request)
  {
    //authorize
    $this->authorize('destroy', $snippet);

    if ($snippet->steps->count() === 1) {
      return response(null, 400);
    }
    $step->delete();
  }
}
