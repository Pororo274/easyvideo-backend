<?php

namespace App\Helpers;

use App\Dto\TempMedia\TempMediaDto;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class MediaHelper
{
    /**
     * @param Collection<TempMediaDto> $tempMedias
     * @return void
     */
    static function removeTempMedias(Collection $tempMedias): void
    {
        $tempMedias->each(function (TempMediaDto $dto) {
            $filename = basename($dto->mediaPath);

            if (Storage::exists("temp-media/{$filename}")) {
                Storage::delete($dto->mediaPath);
            }
        });
    }
}
