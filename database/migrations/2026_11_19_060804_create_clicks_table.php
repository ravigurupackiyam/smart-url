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
        Schema::create('clicks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('short_url_id')->constrained()->cascadeOnDelete();
            $table->string('ip', 45)->nullable();
            $table->string('device', 20)->nullable();       // mobile / desktop / tablet
            $table->string('referrer')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamp('clicked_at')->useCurrent();

            $table->index(['short_url_id', 'clicked_at']);  // analytics queries
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clicks');
    }
};
