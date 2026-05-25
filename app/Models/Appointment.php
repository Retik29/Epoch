<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'professional_id',
        'appointment_date',
        'time_slot',
        'status',
        'notes',
        'meeting_link',
        'fee',
        'confirmed_at',
        'cancelled_at',
        'cancellation_reason',
        'razorpay_order_id',
        'razorpay_payment_id',
        'razorpay_signature',
        'payment_status',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'confirmed_at'     => 'datetime',
        'cancelled_at'     => 'datetime',
        'fee'              => 'decimal:2',
    ];

    // Relationships
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function professional(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Professional::class);
    }

    public function review(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Review::class);
    }

    // Scopes
    public function scopeUpcoming($query)
    {
        return $query->where('appointment_date', '>=', today())
                     ->whereIn('status', ['pending', 'confirmed'])
                     ->orderBy('appointment_date')
                     ->orderBy('time_slot');
    }

    public function scopePast($query)
    {
        return $query->where(function ($q) {
                     $q->where('appointment_date', '<', today())
                       ->orWhere('status', 'completed');
                 })
                 ->orderByDesc('appointment_date');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // Helpers
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isConfirmed(): bool
    {
        return $this->status === 'confirmed';
    }

    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isPaid(): bool
    {
        return $this->payment_status === 'paid';
    }

    public function canBeCancelledByUser(): bool
    {
        return in_array($this->status, ['pending', 'confirmed'])
            && $this->appointment_date->isFuture();
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            'pending'   => 'bg-amber-100 text-amber-800',
            'confirmed' => 'bg-green-100 text-green-800',
            'cancelled' => 'bg-red-100 text-red-800',
            'completed' => 'bg-blue-100 text-blue-800',
            default     => 'bg-gray-100 text-gray-700',
        };
    }
}
