<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreLombaFieldRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'master_fields' => ['nullable', 'array'],
            'master_fields.*' => ['exists:master_fields,id'],
            'required_fields' => ['nullable', 'array'],
            'required_fields.*' => ['exists:master_fields,id'],
            'order' => ['nullable', 'array'],
            'order.*' => ['integer'],
        ];
    }
}
