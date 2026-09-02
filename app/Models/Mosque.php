<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Mosque extends Model
{
    protected $fillable = [
        'organizer_id',
        'name',
        'address',
        'latitude',
        'longitude',
        'google_maps_url',
        'photo',
    ];
    protected $casts = [
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
    ];
    public function organizer(): BelongsTo
    {
        return $this->belongsTo(Organizer::class);
    }
    public function kajians(): HasMany
    {
        return $this->hasMany(Kajian::class);
    }
    public function getFacilitiesAttribute()
    {
        if ($this->relationLoaded('kajians')) {
            $allFacilities = $this->kajians->pluck('facilities')->filter()->map(function($f) {
                $decoded = is_string($f) ? json_decode($f, true) : $f;
                return is_array($decoded) ? $decoded : [];
            })->flatten()->unique()->filter()->values()->toArray();
            return count($allFacilities) > 0 ? implode(', ', $allFacilities) : null;
        }
        return null;
    }
}
