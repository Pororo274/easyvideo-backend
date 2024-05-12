<?php

namespace App\Http\Requests\Media;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\File;

class StoreChunkRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'project_id' => ['required', 'integer'],
            'chunk' => ['required', File::default()->max(1024)],
            'media_uuid' => ['required', 'uuid', 'max:255'],
            'last' => ['required', 'bool'],
            'original_name' => ['required', 'max:255']
        ];
    }
}
