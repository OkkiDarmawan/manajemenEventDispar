<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
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
            'nama_event' => ['required', 'max:255'],

            'deskripsi' => ['required'],

            'penyelenggara' => ['required','string','max:255'],

            'lokasi' => ['required'],

            'link_gmaps' => ['nullable', 'url', 'max:2000'],

            'tanggal_mulai' => ['required', 'date'],

            'tanggal_selesai' => ['required', 'date', 'after_or_equal:tanggal_mulai'],

            'poster' => ['nullable', 'image', 'max:2048'],

            'biaya' => ['required','numeric','min:0'],

        ];
    }
}
