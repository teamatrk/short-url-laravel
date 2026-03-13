<?php

namespace App\Services;

use App\Models\ShortUrl;
use Illuminate\Support\Str;

class ShortCodeService
{
    public function generateUniqueCode(int $length = 8): string
    {
        do {
            $code = Str::lower(Str::random($length));
        } while (ShortUrl::where('code', $code)->exists());

        return $code;
    }
}