<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    public function uploadChunk(Request $request): JsonResponse
    {
        $asset = Asset::query()->where('client_id', $request->input('clientId'))->first();
        $chunk = $request->file('chunk');
        $filepath = $asset->path ?? "assets/" . $chunk->hashName();

        $path = Storage::disk('local')->path($filepath);
        File::append($path, $chunk->get());

        if (is_null($asset)) {
            $asset = Asset::query()->create([
                'client_id' => $request->input('clientId'),
                'path' => $filepath
            ]);
        }

        return response()->json($asset);
    }
}
