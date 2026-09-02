<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Speaker extends Model
{
    protected $fillable = [
        'name',
        'photo',
        'description',
    ];
    public function kajians(): HasMany
    {
        return $this->hasMany(Kajian::class);
    }
}
