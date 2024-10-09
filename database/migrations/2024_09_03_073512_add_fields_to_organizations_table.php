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
            $table->string('other_names')->nullable()->after('name');
            $table->string('info')->nullable()->after('other_names');
            $table->integer('parent_id')->default(0)->after('info');
            $table->string('logo_path')->nullable()->after('parent_id');
            $table->string('address')->nullable()->after('logo_path');
            $table->string('phone')->nullable()->after('address');
            $table->string('email')->nullable()->after('phone');
            $table->string('website')->nullable()->after('email');
            $table->string('vk_url')->nullable()->after('website');
            $table->string('telegram_url')->nullable()->after('vk_url');
            $table->string('region')->nullable()->after('telegram_url');
            $table->string('city')->nullable()->after('region');

            $table->integer('students_count')->default(0)->after('admins_count');
            $table->integer('graduates_count')->default(0)->after('students_count');
            $table->integer('foreign_students_count')->default(0)->after('graduates_count');
            $table->integer('laboratories_count')->default(0)->after('foreign_students_count');
            $table->integer('universities_count')->default(0)->after('laboratories_count');

            $table->boolean('is_blocked')->default(0)->after('other_names');
            $table->string('sub_domen')->nullable()->after('is_blocked');
            $table->integer('store_size')->nullable()->after('sub_domen');
            $table->boolean('is_head')->default(0)->after('store_size');
            $table->boolean('is_basic')->default(0)->after('is_head');
            //nullable(0) лол
            $table->boolean('is_premium')->nullable(0)->after('is_basic');
            $table->boolean('is_testing')->nullable(0)->after('is_premium');
            $table->boolean('member_transfer_network')->nullable(0)->after('is_testing');
            $table->boolean('is_demo')->nullable(0)->after('member_transfer_network');
            $table->boolean('show_catalog')->nullable(0)->after('is_demo');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->dropColumn(['other_names', 'logo_path', 'address', 'phone', 'email', 'website', 'vk_url', 'telegram_url', 'region', 'city',
                'students_count', 'graduates_count', 'foreign_students_count', 'laboratories_count', 'universities_count', 'is_blocked', 'sub_domen',
                'store_size', 'is_basic', 'is_premium', 'is_testing', 'is_demo', 'show_catalog', 'is_head', 'member_transfer_network', 'info']);
        });
    }
};
