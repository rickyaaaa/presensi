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
        Schema::table('kehadiran_models', function (Blueprint $table) {
            $table->string('image_in')->nullable()->after('start_time');
            $table->string('image_out')->nullable()->after('end_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kehadiran_models', function (Blueprint $table) {
            $table->dropColumn(['image_in', 'image_out']);
        });
    }
};
