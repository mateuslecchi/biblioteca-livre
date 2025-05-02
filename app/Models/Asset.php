<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',           // nome
        'description',    // descricao
        'location',       // local
        'acquisition_date', // data_aquisicao
        'condition',      // estado
        'status',         // status
        'tag',            // etiqueta
    ];

    protected $casts = [
        'acquisition_date' => 'date',
    ];

    /**
     * Get the movements for the asset.
     */
    public function movements(): HasMany
    {
        return $this->hasMany(Movement::class);
    }
}