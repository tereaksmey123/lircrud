<?php

use Illuminate\Support\Facades\Schema;
use Modules\LirSetting\app\LirSetting;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (config('lirsetting.migration_enable')) {
            Schema::table(LirSetting::table(), function (Blueprint $table) {
                $table->json('options')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (config('lirsetting.migration_enable')) {
            Schema::table(LirSetting::table(), function (Blueprint $table) {
                $table->dropColumn('options');
            });
        }
    }
};
