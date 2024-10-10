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
        Schema::create('achievements_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organization_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('user_role')->nullable();
            $table->unsignedBigInteger('achievement_id');
            $table->unsignedInteger('achievement_type_id');
            $table->unsignedInteger('record_type_id');
            $table->date('record_date')->nullable();
            $table->string('name');
            $table->text('content');
            $table->integer('document_size')->default(0);
            $table->unsignedInteger('access_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('achievements_records');
    }
};
