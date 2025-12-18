<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();

            // Infos utilisateur (sans compte)
            $table->string('name');
            $table->string('email');
            // Problème réseau
            $table->string('issue_type');
            $table->text('description');
            // Suivi
            $table->enum('status', ['ouvert', 'en_cours', 'resolu'])
                  ->default('ouvert');
            // Assignation technicien (optionnel MVP)
            $table->foreignId('assigned_to')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
