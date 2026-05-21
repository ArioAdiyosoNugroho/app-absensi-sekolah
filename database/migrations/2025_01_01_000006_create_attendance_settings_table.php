<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendance_settings', function (Blueprint $table) {
            $table->id();
            $table->string('school_name');
            $table->time('check_in_start')->default('06:30');
            $table->time('check_in_end')->default('08:00');
            $table->time('check_out_start')->default('14:00');
            $table->time('check_out_end')->default('16:00');
            $table->integer('late_threshold_minutes')->default(15);
            $table->boolean('weekend_enabled')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance_settings');
    }
};
