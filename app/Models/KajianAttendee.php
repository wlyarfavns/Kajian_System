<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class KajianAttendee extends Model
{
    protected $fillable = [
        'kajian_id',
        'user_id',
        'status',
        'checked_in_at',
    ];
    protected $casts = [
        'checked_in_at' => 'datetime',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function kajian(): BelongsTo
    {
        return $this->belongsTo(Kajian::class);
    }
}
