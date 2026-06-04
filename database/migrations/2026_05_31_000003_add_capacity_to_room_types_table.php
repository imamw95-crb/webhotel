<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('room_types', function (Blueprint $table) {
            $table->integer('max_occupancy')->default(2)->after('base_price');
            $table->integer('max_adults')->default(2)->after('max_occupancy');
            $table->integer('max_children')->default(1)->after('max_adults');
            $table->string('room_size')->nullable()->after('max_children');
            $table->string('bed_configuration')->nullable()->after('room_size');
        });
    }

    public function down(): void
    {
        Schema::table('room_types', function (Blueprint $table) {
            $table->dropColumn(['max_occupancy', 'max_adults', 'max_children', 'room_size', 'bed_configuration']);
        });
    }
};
