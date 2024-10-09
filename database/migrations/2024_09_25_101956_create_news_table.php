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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('additional_title')->nullable();
            $table->string('annotation')->nullable();
            $table->string('seo_title')->nullable();
            $table->text('description')->nullable();
            $table->text('keywords')->nullable();
            $table->boolean('visibility')->nullable();
            $table->text('tags')->nullable();
            $table->string('preview_path')->nullable();
            $table->string('preview_name')->nullable();
            $table->text('text')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
