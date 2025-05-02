<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',           // nome
        'author',         // autor
        'quantity',       // quantidade
        'collection_name', // colecao
        'description',    // descricao
        'isbn',           // isbn
        'notes',          // observacao
        'tag',            // etiqueta
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        // Gera a etiqueta automaticamente antes de salvar
        static::creating(function ($collection) {
            if (empty($collection->tag)) {
                $collection->tag = self::generateNextTag();
            }
        });
    }

    /**
     * Gera a próxima etiqueta legível sequencial no formato L-00001, L-0000A, etc.
     */
    public static function generateNextTag(): string
    {
        $prefix = 'L-';

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