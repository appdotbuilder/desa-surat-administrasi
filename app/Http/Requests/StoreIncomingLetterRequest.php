<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIncomingLetterRequest extends FormRequest
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
            'letter_number' => 'required|string|max:255|unique:incoming_letters,letter_number',
            'sender' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'letter_date' => 'required|date',
            'received_date' => 'required|date|after_or_equal:letter_date',
            'priority' => 'required|in:low,medium,high',
            'status' => 'in:new,processed,disposed,archived',
            'description' => 'nullable|string',
            'file_path' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
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
            'letter_number.required' => 'Nomor surat harus diisi.',
            'letter_number.unique' => 'Nomor surat sudah digunakan.',
            'sender.required' => 'Pengirim surat harus diisi.',
            'subject.required' => 'Perihal surat harus diisi.',
            'letter_date.required' => 'Tanggal surat harus diisi.',
            'received_date.required' => 'Tanggal diterima harus diisi.',
            'received_date.after_or_equal' => 'Tanggal diterima tidak boleh sebelum tanggal surat.',
            'priority.required' => 'Prioritas surat harus dipilih.',
            'priority.in' => 'Prioritas surat tidak valid.',
        ];
    }
}