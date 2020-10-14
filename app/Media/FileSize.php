<?php

namespace App\Media;

use Illuminate\Support\Facades\Config;

class FileSize
{

  public static function max_file_size()
  {
    return [
      'b' => Config::get('media-library.max_file_size'),
      'kb' => intval(Config::get('media-library.max_file_size') / 1000),
      'mb' => intval(Config::get('media-library.max_file_size') / 1000000)
    ];
  }
}
