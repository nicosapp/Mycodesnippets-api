<?php

namespace App\Http\Controllers\Media;

use App\Media\FileSize;
use App\Media\MimeTypes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class MediaConfigController extends Controller
{
  public function index()
  {
    return response()->json([
      'data' => [
        'mimetypes' => [
          'image' => MimeTypes::$image,
          'video' => MimeTypes::$video
        ],
        'max_file_size' => FileSize::max_file_size()
      ]
    ]);
  }
}
