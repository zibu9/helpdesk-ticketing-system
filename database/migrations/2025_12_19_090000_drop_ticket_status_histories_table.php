<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('ticket_status_histories');
    }

    public function down(): void
    {
        Schema::create('ticket_status_histories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('ticket_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->enum('old_status', ['ouvert', 'en_cours', 'resolu']);
            $table->enum('new_status', ['ouvert', 'en_cours', 'resolu']);

            $table->foreignId('changed_by')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }
};
