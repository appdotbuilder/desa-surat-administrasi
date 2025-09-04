<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDispositionRequest extends FormRequest
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
            'incoming_letter_id' => 'required|exists:incoming_letters,id',
            'assigned_to' => 'required|exists:users,id',
            'instructions' => 'required|string',
            'priority' => 'required|in:low,medium,high',
            'status' => 'in:pending,in_progress,completed',
            'due_date' => 'nullable|date|after:today',
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
            'incoming_letter_id.required' => 'Surat masuk harus dipilih.',
            'incoming_letter_id.exists' => 'Surat masuk tidak valid.',
            'assigned_to.required' => 'Petugas yang ditugaskan harus dipilih.',
            'assigned_to.exists' => 'Petugas tidak valid.',
            'instructions.required' => 'Instruksi disposisi harus diisi.',
            'priority.required' => 'Prioritas harus dipilih.',
            'priority.in' => 'Prioritas tidak valid.',
            'due_date.after' => 'Batas waktu harus setelah hari ini.',
        ];
    }
}