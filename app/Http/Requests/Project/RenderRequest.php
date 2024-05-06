<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class RenderRequest extends FormRequest
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
            'nodes' => [ 'required', 'array']
        ];
    }
}
