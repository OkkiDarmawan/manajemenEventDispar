<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMasterFieldRequest extends FormRequest
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
             'label' => [
                'required',
                'max:100',
            ],

            'nama_field' => [
                'required', 
                Rule::unique('master_fields', 'nama_field')->ignore($this->master_field),
            ],

            'tipe' => [
                'required',
            ],

            'kategori' => [
                'required',
            ],

            'placeholder' => [
                'required',
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
