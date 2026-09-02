<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Organizer extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'phone',
        'logo',
        'address',
        'latitude',
        'longitude',
        'is_verified',
    ];
    protected $casts = [
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'is_verified' => 'boolean',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function mosques(): HasMany
    {
        return $this->hasMany(Mosque::class);
    }
    public function kajians(): HasMany
    {
        return $this->hasMany(Kajian::class);
    }
}
