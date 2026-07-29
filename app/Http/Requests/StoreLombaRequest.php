<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreLombaRequest extends FormRequest
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
            'event_id' => ['required', 'exists:events,id'],

            'nama_lomba' => ['required', 'max:255'],

            'deskripsi' => ['required'],

            'syarat' => ['required'],

            'kuota' => ['required', 'integer', 'min:1'],

            'biaya' => ['required', 'numeric', 'min:0'],

            'hadiah' => ['required'],

            'pendaftaran_terbuka' => ['required', 'date'],

            'pendaftaran_tertutup' => [
                'required',
                'date',
                'after_or_equal:pendaftaran_terbuka',
            ],

        ];
    }
}
