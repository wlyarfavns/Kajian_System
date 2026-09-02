<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
class Kajian extends Model
{
    protected $fillable = [
        'organizer_id',
        'mosque_id',
        'speaker_id',
        'category_id',
        'title',
        'slug',
        'description',
        'poster',
        'start_at',
        'end_at',
        'address',
        'latitude',
        'longitude',
        'google_maps_url',
        'audience',
        'is_family_friendly',
        'is_free',
        'price',
        'quota',
        'status',
        'is_verified',
        'facilities',
    ];
    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'is_family_friendly' => 'boolean',
        'is_free' => 'boolean',
        'is_verified' => 'boolean',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
    ];
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (Kajian $model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
            if (empty($model->slug)) {
                $baseSlug = Str::slug($model->title);
                $slug = $baseSlug;
                
                while (self::where('slug', $slug)->exists()) {
                    $slug = $baseSlug . '-' . Str::random(5);
                }
                $model->slug = $slug;
            }
        });
    }
    public function organizer(): BelongsTo
    {
        return $this->belongsTo(Organizer::class);
    }
    public function mosque(): BelongsTo
    {
        return $this->belongsTo(Mosque::class);
    }
    public function speaker(): BelongsTo
    {
        return $this->belongsTo(Speaker::class);
    }
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function attendees(): HasMany
    {
        return $this->hasMany(KajianAttendee::class);
    }
    public function favoritedBy(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }
    public function scopeNearby($query, $lat, $lng, $radius = 5)
    {
        $query->where('status', 'published');
        if ($lat !== null && $lng !== null) {
            $haversine = "(6371 * acos(cos(radians($lat)) * cos(radians(latitude)) * cos(radians(longitude) - radians($lng)) + sin(radians($lat)) * sin(radians(latitude))))";
            $query->select('*')
                  ->selectRaw("{$haversine} AS distance")
                  ->whereRaw("{$haversine} <= ?", [$radius])
                  ->orderBy('distance', 'ASC');
        } else {
            $query->orderBy('start_at', 'ASC');
        }
        return $query;
    }
    public function getStatusLabelAttribute(): string
    {
        if ($this->status === 'cancelled') {
            return 'Dibatalkan';
        }
        $now = now();
        if ($this->end_at && $now > $this->end_at) {
            return 'Selesai';
        }
        if ($this->start_at && $this->end_at && $now >= $this->start_at && $now <= $this->end_at) {
            return 'Sedang Berlangsung';
        }
        if ($this->start_at && $now < $this->start_at) {
            $diffInMinutes = (int) $now->diffInMinutes($this->start_at);
            if ($diffInMinutes < 60) {
                return "Mulai {$diffInMinutes} menit lagi";
            }
            return "Akan Datang";
        }
        return 'Tidak Diketahui';
    }
}
