<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Sinkronisasi harga tipe kamar dari PMS setiap 6 jam
Schedule::command('pms:sync-prices')->everySixHours()->appendOutputTo(storage_path('logs/pms-sync.log'));

// Batalkan otomatis booking yang sudah melebihi batas pembayaran 3 jam
Schedule::command('booking:auto-cancel-expired')->everyMinute()->appendOutputTo(storage_path('logs/booking-auto-cancel.log'));
