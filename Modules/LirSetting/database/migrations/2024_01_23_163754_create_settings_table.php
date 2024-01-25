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
            Schema::create(LirSetting::table(), function (Blueprint $table) {
                $table->id();
                $table->string('key')->index();
                $table->string('type')->default(LirSetting::DEFAULT_TYPE)->index();
                $table->string('name');
                $table->string('description')->nullable();
                $table->text('value')->nullable();
                $table->text('field');
                $table->tinyInteger('active');
                $table->timestamps();
                $table->unique(['key', 'type']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (config('lirsetting.migration_enable')) {
            Schema::dropIfExists(LirSetting::table());
        }
    }
};
