<?php

namespace App\Helpers;

class MediaHelper
{
    public static function getMediaUrl(string $path): string
    {
        return url('/api/media/file?path=' . $path);
    }
}
