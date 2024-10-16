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
        Schema::table('organizations', function (Blueprint $table) {
            $table->boolean('is_premium')->default(0)->change();
            $table->boolean('is_testing')->default(0)->change();
            $table->boolean('member_transfer_network')->default(0)->change();
            $table->boolean('is_demo')->default(0)->change();
            $table->boolean('show_catalog')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->boolean('is_premium')->change();
            $table->boolean('is_testing')->change();
            $table->boolean('member_transfer_network')->change();
            $table->boolean('is_demo')->change();
            $table->boolean('show_catalog')->change();
        });
    }
};
