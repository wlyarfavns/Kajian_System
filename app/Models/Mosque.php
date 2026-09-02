<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Representasi dari entitas masjid sebagai lokasi pelaksanaan kajian.
 */
class Mosque extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'organizer_id',
        'name',
        'address',
        'latitude',
        'longitude',
        'google_maps_url',
        'photo',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
    ];

    /**
     * Relasi ke organizer yang menaungi atau mendaftarkan masjid ini.
     */
    public function organizer(): BelongsTo
    {
        return $this->belongsTo(Organizer::class);
    }

    /**
     * Relasi ke daftar kajian yang diselenggarakan di masjid ini.
     */
    public function kajians(): HasMany
    {
        return $this->hasMany(Kajian::class);
    }

    /**
     * Mengambil daftar fasilitas gabungan dari semua kajian yang ada di masjid ini.
     */
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
