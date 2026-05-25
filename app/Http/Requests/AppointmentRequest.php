<?php

namespace App\Http\Requests;

use App\Rules\SlotAvailableRule;
use Illuminate\Foundation\Http\FormRequest;

class AppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'professional_id'  => ['required', 'string', 'exists:professionals,_id'],
            'appointment_date' => ['required', 'date', 'after:today'],
            'time_slot'        => [
                'required',
                'string',
                'max:20',
                new SlotAvailableRule(
                    $this->input('professional_id'),
                    $this->input('appointment_date')
                ),
            ],
            'notes'            => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'professional_id.required'  => 'Please select a professional.',
            'professional_id.exists'    => 'The selected professional does not exist.',
            'appointment_date.required' => 'Please select an appointment date.',
            'appointment_date.after'    => 'The appointment date must be a future date.',
            'time_slot.required'        => 'Please select a time slot.',
            'time_slot.regex'           => 'The time slot format is invalid.',
            'notes.max'                 => 'Notes cannot exceed 500 characters.',
        ];
    }

    protected function prepareForValidation(): void
    {
        // Trim whitespace
        if ($this->filled('notes')) {
            $this->merge(['notes' => trim($this->notes)]);
        }
    }
}
