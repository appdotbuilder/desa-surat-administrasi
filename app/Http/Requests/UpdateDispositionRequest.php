<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDispositionRequest extends FormRequest
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
            'assigned_to' => 'required|exists:users,id',
            'instructions' => 'required|string',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,in_progress,completed',
            'due_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'completion_notes' => 'nullable|string|required_if:status,completed',
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
            'assigned_to.required' => 'Petugas yang ditugaskan harus dipilih.',
            'assigned_to.exists' => 'Petugas tidak valid.',
            'instructions.required' => 'Instruksi disposisi harus diisi.',
            'priority.required' => 'Prioritas harus dipilih.',
            'priority.in' => 'Prioritas tidak valid.',
            'status.required' => 'Status harus dipilih.',
            'status.in' => 'Status tidak valid.',
            'completion_notes.required_if' => 'Catatan penyelesaian wajib diisi jika status selesai.',
        ];
    }
}