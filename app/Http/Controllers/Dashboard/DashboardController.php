<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Http\Resources\SnippetLightResource;

class DashboardController extends Controller
{
  public function lastCreated(Request $request)
  {
    return SnippetLightResource::collection(
      $request->user()->snippets()->latest('created_at')->limit(10)->get()
    );
  }

  public function lastUpdated(Request $request)
  {
    return SnippetLightResource::collection(
      $request->user()->snippets()->latest('updated_at')->limit(10)->get()
    );
  }

  public function mostViewed(Request $request)
  {
    return SnippetLightResource::collection(
      $request->user()->snippets()->latest('viewed')->latest('updated_at')->limit(10)->get()
    );
  }

  public function statistics(Request $request)
  {
    return [
      'data' => [
        'today_count' => $request->user()->snippets()->whereDate('created_at', Carbon::today())->count(),
        'last_week_count' => $request->user()->snippets()->where('created_at', '>', Carbon::today()->subDays(7))->count(),
        'last_month_count' => $request->user()->snippets()->where('created_at', '>', Carbon::today()->subMonth(1))->count(),
        'count' => $request->user()->snippets()->count(),
      ]
    ];
  }
}
