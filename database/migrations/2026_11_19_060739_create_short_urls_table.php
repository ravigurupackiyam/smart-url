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
        Schema::create('short_urls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('code', 10)->unique(); // unique index = fast lookup + collision guard
            $table->text('original_url');
            $table->timestamp('expires_at')->nullable()->index();
            $table->unsignedBigInteger('clicks_count')->default(0);
            $table->timestamps();

            $table->index(['user_id', 'created_at']); // dashboard listing
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('short_urls');
    }
};
