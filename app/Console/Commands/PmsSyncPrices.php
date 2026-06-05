<?php

namespace App\Console\Commands;

use App\Models\RoomType;
use App\Services\PmsApiService;
use Illuminate\Console\Command;

class PmsSyncPrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pms:sync-prices
                           {--dry-run : Jangan update, hanya tampilkan yang akan diubah}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sinkronisasi harga tipe kamar dari PMS ke database lokal';

    /**
     * Execute the console command.
     */
    public function handle(PmsApiService $pms): int
    {
        $this->info('Mengambil data harga dari PMS...');

        $pmsTypes = $pms->getRoomTypePrices();

        if (empty($pmsTypes)) {
            $this->warn('Tidak ada data dari PMS. Pastikan PMS server berjalan.');

            return Command::FAILURE;
        }

        $totalTypes = count($pmsTypes);
        $this->line("Ditemukan {$totalTypes} tipe kamar dari PMS.");
        $this->newLine();

        $updated = 0;
        $skipped = 0;
        $failed = 0;
        $dryRun = $this->option('dry-run');

        foreach ($pmsTypes as $pmsType) {
            $pmsCode = $pmsType['code'] ?? '';
            $pmsName = $pmsType['name'] ?? '';
            $pmsPrice = $pmsType['prices']['effective_min'] ?? 0;

            // Cari local room type
            $local = RoomType::where('code', $pmsCode)
                ->orWhere('name', $pmsName)
                ->first();

            if (! $local) {
                $this->warn("  [SKIP] Tipe kamar tidak ditemukan di lokal: {$pmsName} ({$pmsCode})");
                $skipped++;

                continue;
            }

            $oldPrice = (float) $local->base_price;
            $newPrice = (float) $pmsPrice;

            if ($oldPrice === $newPrice || $newPrice <= 0) {
                $this->line("  [=] {$local->name}: Rp ".number_format($oldPrice, 0, ',', '.'));
                $skipped++;

                continue;
            }

            if ($dryRun) {
                $this->info(
                    "  [DRY] {$local->name}: Rp ".number_format($oldPrice, 0, ',', '.').
                    ' → Rp '.number_format($newPrice, 0, ',', '.')
                );
                $updated++;

                continue;
            }

            $local->update(['base_price' => $newPrice]);
            $this->info(
                "  [OK] {$local->name}: Rp ".number_format($oldPrice, 0, ',', '.').
                ' → Rp '.number_format($newPrice, 0, ',', '.')
            );
            $updated++;
        }

        $this->newLine();

        if ($dryRun) {
            $this->info("Dry-run selesai. {$updated} akan diupdate, {$skipped} sama/skip, {$failed} gagal.");
        } else {
            // Clear cache setelah sync
            $pms->clearCache();
            $this->info("Sinkronisasi selesai. {$updated} diupdate, {$skipped} sama/skip, {$failed} gagal.");
        }

        return Command::SUCCESS;
    }
}
