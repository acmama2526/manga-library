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
        Schema::table('volumes', function (Blueprint $table) {
            $table->string('read_url')->nullable()->after('platform_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    //ロールバック用
    public function down(): void
    {
        Schema::table('volumes', function (Blueprint $table) {
            $table->dropColumn('read_url');
        });
    }
};
