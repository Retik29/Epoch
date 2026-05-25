<?php

namespace App\Rules;

use App\Models\Appointment;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class SlotAvailableRule implements ValidationRule
{
    public function __construct(
        protected ?string $professionalId,
        protected ?string $date
    ) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->professionalId || !$this->date) {
            return;
        }

        $exists = Appointment::where('professional_id', $this->professionalId)
            ->where('appointment_date', $this->date)
            ->where('time_slot', $value)
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($exists) {
            $fail('This time slot is already booked. Please choose another slot.');
        }
    }
}
