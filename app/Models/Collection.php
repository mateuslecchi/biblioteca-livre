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
}