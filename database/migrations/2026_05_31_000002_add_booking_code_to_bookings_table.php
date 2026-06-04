<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('booking_code', 20)->unique()->nullable()->after('id');
            $table->decimal('total_amount', 12, 2)->nullable()->after('guests');
            $table->string('payment_status')->default('unpaid')->after('status');
            $table->string('payment_method')->nullable()->after('payment_status');
            $table->timestamp('paid_at')->nullable()->after('payment_method');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['booking_code', 'total_amount', 'payment_status', 'payment_method', 'paid_at']);
        });
    }
};
