<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLetterArchiveRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'letter_type' => 'required|in:incoming,outgoing',
            'letter_id' => 'required|integer',
            'archive_number' => 'required|string|max:255|unique:letter_archives,archive_number',
            'category' => 'required|string|max:255',
            'archive_notes' => 'nullable|string',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'letter_type.required' => 'Jenis surat harus dipilih.',
            'letter_type.in' => 'Jenis surat tidak valid.',
            'letter_id.required' => 'Surat harus dipilih.',
            'archive_number.required' => 'Nomor arsip harus diisi.',
            'archive_number.unique' => 'Nomor arsip sudah digunakan.',
            'category.required' => 'Kategori arsip harus diisi.',
        ];
    }
}