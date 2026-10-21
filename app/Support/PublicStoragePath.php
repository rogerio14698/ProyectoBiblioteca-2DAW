<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Support\Str;

class PublicStoragePath
{
    public static function normalize(string $path): ?string
    {
        $path = str_replace('\\', '/', trim($path));

        if (Str::startsWith($path, ['http://', 'https://', '//'])) {
            return null;
        }

        $path = ltrim($path, '/');
        $path = preg_replace('#^(?:(?:public|storage)/)+#i', '', $path) ?? $path;

        return $path !== '' ? $path : null;
    }

    public static function url(?string $path): ?string
    {
        if ($path === null || $path === '') {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://', '//'])) {
            return $path;
        }

        $normalizedPath = self::normalize($path);

        return $normalizedPath !== null ? asset('storage/' . $normalizedPath) : null;
    }
}
