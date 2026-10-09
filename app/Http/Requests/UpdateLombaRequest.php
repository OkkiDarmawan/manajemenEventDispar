<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateLombaRequest extends FormRequest
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
            'nama_lomba' => ['required', 'string', 'max:255'], 
            'penyelenggara' => ['nullable', 'string', 'max:255'], 
            'deskripsi' => ['nullable', 'string'], 
            'syarat' => ['nullable', 'string'], 
            'lokasi' => ['nullable', 'string', 'max:255'],
            'kuota' => ['required', 'integer', 'min:1'], 
            'link_gmaps' => ['nullable', 'url', 'max:2000'],
            'biaya' => ['required', 'numeric', 'min:0'], 
            'hadiah' => ['nullable', 'string', 'max:255'], 
            'pendaftaran_terbuka' => ['nullable', 'date'], 
            'pendaftaran_tertutup' => ['nullable', 'date', 'after_or_equal:pendaftaran_terbuka'], 
            'poster' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
    }
}
