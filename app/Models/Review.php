<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'professional_id', 'appointment_id', 'rating', 'comment'];

    protected $casts = [
        'rating' => 'integer',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function professional(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Professional::class);
    }

    public function appointment(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }

    protected static function booted(): void
    {
        static::saved(function (Review $review) {
            $review->professional->updateRating();
        });

        static::deleted(function (Review $review) {
            $review->professional->updateRating();
        });
    }
}
