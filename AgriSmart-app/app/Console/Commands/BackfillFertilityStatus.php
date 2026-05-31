<?php

namespace App\Console\Commands;

use App\Models\SoilNutrient;
use App\Services\SoilAnalysisService;
use Illuminate\Console\Command;

class BackfillFertilityStatus extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'soil:backfill-status
                            {--force : Proses ulang semua data, termasuk yang sudah punya status}';

    /**
     * The console command description.
     */
    protected $description = 'Backfill status kesuburan dari Flask ML untuk data yang belum punya status';

    /**
     * Execute the console command.
     */
    public function handle(SoilAnalysisService $analysisService): int
    {
        $query = SoilNutrient::with('block');

        if (!$this->option('force')) {
            $query->whereNull('fertility_status');
        }

        $nutrients = $query->get();
        $count = $nutrients->count();

        if ($count === 0) {
            $this->info('✅ Semua data sudah memiliki status kesuburan.');
            return self::SUCCESS;
        }

        $this->info("🔄 Memproses {$count} data unsur hara...");
        $this->newLine();

        $bar = $this->output->createProgressBar($count);
        $bar->start();

        $success = 0;
        $failed  = 0;

        foreach ($nutrients as $nutrient) {
            try {
                $result = $analysisService->predictAndSave($nutrient);
                $blockName = $nutrient->block->name ?? "Block #{$nutrient->block_id}";

                $this->line('');
                $this->line("  ✅ {$blockName}: {$result['status']}");
                $success++;
            } catch (\Throwable $e) {
                $failed++;
                $this->line('');
                $this->error("  ❌ Nutrient #{$nutrient->id}: {$e->getMessage()}");
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        $this->info("📊 Hasil:");
        $this->line("   Berhasil: {$success}");
        $this->line("   Gagal:    {$failed}");

        if ($failed > 0) {
            $this->warn("⚠️  Pastikan Flask ML berjalan dan coba lagi untuk data yang gagal.");
        }

        return $failed > 0 ? self::FAILURE : self::SUCCESS;
    }
}
