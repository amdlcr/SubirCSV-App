<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CsvRequest extends FormRequest
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
           'anadirArchivo' => 'required|file|mimes:csv,txt'
        ];
    }

    public function messages(): array
    {
        return [
            'anadirArchivo.required' => 'Debes subir un archivo.',
            'anadirArchivo.file' => 'Debes subir un archivo válido.',
            'anadirArchivo.mimes' => 'El archivo debe ser tipo csv o txt.'
        ];
    }
}
