<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;
use Carbon\Carbon;

class Professional extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'bio',
        'experience_years',
        'location',
        'photo',
        'consultation_fee',
        'session_duration',
        'is_active',
        'rating',
        'total_reviews',
        'specializations',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'specializations' => 'array',
        'consultation_fee' => 'decimal:2',
        'rating' => 'decimal:2',
    ];

    // Relationships
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function appointments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function availabilities(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Availability::class);
    }

    public function reviews(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Review::class);
    }

    // Helpers
    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo) {
            if (filter_var($this->photo, FILTER_VALIDATE_URL)) {
                return $this->photo;
            }
            return asset('storage/' . $this->photo);
        }

        $name = $this->user->name ?? 'Pro';
        $fallbackPhotos = [
            'Dr. Arjun Nair' => 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?q=80&w=600&auto=format&fit=crop',
            'Dr. Pooja Pillai' => 'https://images.unsplash.com/photo-1594824813573-246434de83fb?q=80&w=600&auto=format&fit=crop',
            'Prof. Sameer Khan' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=600&auto=format&fit=crop',
            'Adv. Neha Desai' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=600&auto=format&fit=crop',
            'Mr. Kiran Rao' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?q=80&w=600&auto=format&fit=crop',
            'Dr. Anjali Singh' => 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?q=80&w=600&auto=format&fit=crop',
            'Dr. Vivek Joshi' => 'https://images.unsplash.com/photo-1537368910025-700350fe46c7?q=80&w=600&auto=format&fit=crop',
            'Ms. Rekha Thomas' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?q=80&w=600&auto=format&fit=crop',
            'Prof. Suresh Iyer' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?q=80&w=600&auto=format&fit=crop',
            'Dr. Lakshmi Reddy' => 'https://images.unsplash.com/photo-1614608682850-e0d6ed316d47?q=80&w=600&auto=format&fit=crop',
            'Mr. Aditya Bose' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=600&auto=format&fit=crop',
            'Adv. Preeti Menon' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?q=80&w=600&auto=format&fit=crop',
            'Dr. Rajesh Gupta' => 'https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?q=80&w=600&auto=format&fit=crop',
            'Prof. Nidhi Shah' => 'https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?q=80&w=600&auto=format&fit=crop',
            'Mr. Harish Verma' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=600&auto=format&fit=crop',
            'Dr. Priya Sharma' => 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?q=80&w=600&auto=format&fit=crop',
            'Prof. Rahul Mehta' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=600&auto=format&fit=crop',
            'Adv. Sunita Kapoor' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=600&auto=format&fit=crop',
            'Mr. Arun Verma' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?q=80&w=600&auto=format&fit=crop',
            'Dr. Meera Nair' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?q=80&w=600&auto=format&fit=crop',
        ];

        if (isset($fallbackPhotos[$name])) {
            return $fallbackPhotos[$name];
        }

        $encodedName = urlencode($name);
        return "https://ui-avatars.com/api/?name={$encodedName}&background=6366f1&color=fff&size=256";
    }

    /**
     * Get available time slots for a specific date.
     */
    public function getAvailableSlotsForDate(string $date): array
    {
        $carbon = Carbon::parse($date);
        $dayOfWeek = $carbon->dayOfWeek; // 0=Sun, 6=Sat

        $availability = $this->availabilities()
            ->where('day_of_week', $dayOfWeek)
            ->where('is_active', true)
            ->first();

        if (!$availability) {
            return [];
        }

        $slots = [];
        $duration = $this->session_duration ?: 30;
        $start = Carbon::parse($availability->start_time);
        $end = Carbon::parse($availability->end_time);

        while ($start->copy()->addMinutes($duration)->lte($end)) {
            $slotLabel = $start->format('H:i') . '-' . $start->copy()->addMinutes($duration)->format('H:i');
            $slots[] = $slotLabel;
            $start->addMinutes($duration);
        }

        // Remove already booked slots
        $booked = $this->appointments()
            ->where('appointment_date', $date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->pluck('time_slot')
            ->toArray();

        return array_values(array_diff($slots, $booked));
    }

    public function updateRating(): void
    {
        $avg = $this->reviews()->avg('rating');
        $count = $this->reviews()->count();
        $this->update(['rating' => round($avg, 2), 'total_reviews' => $count]);
    }
}
