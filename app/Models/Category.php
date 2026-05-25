<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'icon', 'color'];

    public function professionals(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Professional::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
