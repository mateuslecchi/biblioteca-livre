<?php

namespace App\Models;

use App\Observers\MovementObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy(MovementObserver::class)]
class Movement extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',       // bem_id
        'origin_location', // local_origem
        'destination_location', // local_destino
        'responsible',    // responsavel
        'notes',          // observacao
    ];

    /**
     * Get the asset that owns the movement.
     */
    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }
}