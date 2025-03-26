<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'lodging', 'places_to_visit', 'activities', 'foods_to_try', 'itinerary_id'];

    protected $casts = [
        'places_to_visit' => 'array',
        'activities' => 'array',
        'foods_to_try' => 'array',
    ];

    public function itinerary() {
        return $this->belongsTo(Itinerary::class);
    }
}
