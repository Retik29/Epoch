<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class Availability extends Model
{
    use HasFactory;

    protected $fillable = ['professional_id', 'day_of_week', 'start_time', 'end_time', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
        'day_of_week' => 'integer',
    ];

    public function professional(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Professional::class);
    }

    public function getDayNameAttribute(): string
    {
        $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        return $days[$this->day_of_week] ?? 'Unknown';
    }
}
