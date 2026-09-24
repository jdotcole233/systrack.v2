<?php

namespace App\Utilities;

use Illuminate\Support\Facades\Log;

class Utilities
{
  public static function normalizeForHash(array $data): array
  {
    ksort($data); // key order shouldn't matter

    foreach ($data as $key => $value) {
      if (is_array($value)) {
        $data[$key] = (new self)->normalizeForHash($value);
      } elseif (is_string($value)) {
        $data[$key] = strtolower(trim($value));
      }
    }

    Log::info("message", [
      'data' => $data
    ]);
    return $data;
  }
}
