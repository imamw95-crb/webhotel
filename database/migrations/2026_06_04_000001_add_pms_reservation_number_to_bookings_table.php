<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('pms_reservation_number', 100)->nullable()->after('booking_code');
            $table->index('pms_reservation_number');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropIndex(['pms_reservation_number']);
            $table->dropColumn('pms_reservation_number');
        });
    }
};
