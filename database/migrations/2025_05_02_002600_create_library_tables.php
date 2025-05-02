<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create assets table (bens)
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('name');                  // nome
            $table->text('description')->nullable(); // descricao
            $table->string('location');              // local
            $table->date('acquisition_date');        // data_aquisicao
            $table->string('condition');             // estado
            $table->string('status');                // status
            $table->string('tag')->unique();         // etiqueta
            $table->timestamps();
        });

        // Create movements table (movimentacoes)
        Schema::create('movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')            // bem_id
                  ->constrained()
                  ->onDelete('cascade');
            $table->string('origin_location');       // local_origem
            $table->string('destination_location');  // local_destino
            $table->string('responsible');           // responsavel
            $table->text('notes')->nullable();       // observacao
            $table->timestamps();
        });

        // Create collections table (acervo)
        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->string('name');                  // nome
            $table->string('author');                // autor
            $table->integer('quantity')->default(1); // quantidade
            $table->string('collection_name')->nullable(); // colecao
            $table->text('description')->nullable(); // descricao
            $table->string('isbn')->nullable();      // isbn
            $table->text('notes')->nullable();       // observacao
            $table->string('tag')->unique();         // etiqueta
            $table->timestamps();
        });
    }
};
