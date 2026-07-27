<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreMasterFieldRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'label' => [
                'required',
                'max:100',
            ],

            'nama_field' => [
                'required', 
                'unique:master_fields,nama_field',
            ],

            'tipe' => [
                'required',
            ],

            'kategori' => [
                'nullable',
            ],

            'placeholder' => [
                'nullable',
            ],

            'aktif' => [
                'required', 
                'boolean',
            ],

            'readonly' => [
                'nullable', 
                'boolean',
            ],
        ];
    }
}
