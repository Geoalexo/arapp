<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title')->unique();
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('image');
            $table->text('marker_image');
            $table->text('marker_pattern');
            $table->text('gltf_model');
            $table->boolean('emit_events')->default(false);
            $table->boolean('smooth')->default(false);
            $table->decimal('smooth_count')->default(5);
            $table->decimal('smooth_tolerance')->default(0.01);
            $table->decimal('smooth_threshold')->default(2);
            $table->json('position');
            $table->json('rotation');
            $table->json('scale');
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sights');
    }
};
