<?php

namespace App\Models;

use App\Enums\AssetStatus;
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
        'status' => AssetStatus::class
    ];

    /**
     * Get the movements for the asset.
     */
    public function movements(): HasMany
    {
        return $this->hasMany(Movement::class);
    }

    protected static function boot()
    {
        parent::boot();

        // Gera a etiqueta automaticamente antes de salvar
        static::creating(function ($asset) {
            if (empty($asset->tag)) {
                $asset->tag = self::generateNextTag();
            }
        });
    }

    /**
     * Gera a próxima etiqueta legível sequencial no formato P-XXXXX
     */
    public static function generateNextTag(): string
    {
        $prefix = 'P-';

        // Busca a última tag gerada
        $lastTag = self::where('tag', 'like', $prefix . '%')
            ->orderByDesc('tag')
            ->value('tag');

        if ($lastTag) {
            // Extrai a parte numérica e converte de base 36 para decimal
            $lastPart = substr($lastTag, strlen($prefix));
            $nextNumber = base_convert($lastPart, 36, 10);
            $nextNumber++;
        } else {
            $nextNumber = 1;
        }

        // Converte de volta para base 36 e coloca em maiúsculas
        $nextPart = strtoupper(base_convert($nextNumber, 10, 36));

        // Formata com zeros à esquerda para ter sempre 5 caracteres
        $nextPart = str_pad($nextPart, 5, '0', STR_PAD_LEFT);

        return $prefix . $nextPart;
    }
}