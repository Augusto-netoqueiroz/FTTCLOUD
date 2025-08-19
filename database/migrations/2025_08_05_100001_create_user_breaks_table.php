<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('user_breaks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_session_id')->constrained()->cascadeOnDelete();
            $table->string('type');              // tipo de pausa (ex.: almoço, reunião)
            $table->timestamp('started_at');
            $table->timestamp('ended_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('user_breaks');
    }
};
