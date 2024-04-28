<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    public function uploadChunk(Request $request): JsonResponse
    {
        $asset = Asset::query()->where('client_id', $request->input('clientId'))->first();

        if (is_null($asset)) {
            $path = $request->file('chunk')->store('', 'editor-assets');
            $asset = Asset::query()->create([
                'client_id' => $request->input('clientId'),
                'path' => $path
            ]);
        } else {
            Storage::append($asset->path, $request->file('chunk')->get());
        }

        return response()->json($asset);
    }
}
