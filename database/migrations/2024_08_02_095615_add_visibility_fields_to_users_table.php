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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('name_visibility')->default(1)->after('group');
            $table->boolean('email_visibility')->default(1)->after('name_visibility');
            $table->boolean('portfolio_card_access')->default(1)->after('email_visibility');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('name_visibility');
            $table->dropColumn('email_visibility');
            $table->dropColumn('portfolio_card_access');
        });
    }
};
