<?php

namespace App\Services;

use App\Models\ShortUrl;

class CodeGenerator
{
    /**
     * Create a new class instance.
     */

    private const ALPHABET = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    public function generate(int $length = 6): string
    {
        for ($attempt = 0; $attempt < 5; $attempt++) {
            $code = '';
            for ($i = 0; $i < $length; $i++) {
                $code .= self::ALPHABET[random_int(0, 61)];
            }
            if (!ShortUrl::where('code', $code)->exists()) {
                return $code;
            }
        }
        return $this->generate($length + 1);
    }
}
