<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

/**
 * Membersihkan file upload sementara (temp/*) yang gagal/tidak diproses worker.
 *
 * File temp normalnya dihapus otomatis oleh FileStorageService::moveFromTemp()
 * setelah worker sukses. Command ini menyapu sisa file "orphan" bila job tidak
 * pernah jalan (mis. worker mati), agar storage tetap bersih.
 *
 * Dijadwalkan harian di routes/console.php.
 */
class CleanupTempUploads extends Command
{
    protected $signature = 'uploads:cleanup-temp {--hours=24 : Hapus file temp yang lebih tua dari N jam}';

    protected $description = 'Hapus file upload sementara (temp/*) yang lebih tua dari batas waktu tertentu';

    public function handle(): int
    {
        $hours = (int) $this->option('hours');
        $threshold = Carbon::now()->subHours($hours)->getTimestamp();
        $disk = Storage::disk('local');

        if (! $disk->exists('temp')) {
            $this->info('Tidak ada folder temp. Tidak ada yang dibersihkan.');

            return self::SUCCESS;
        }

        $deleted = 0;

        foreach ($disk->allFiles('temp') as $file) {
            if ($disk->lastModified($file) < $threshold) {
                $disk->delete($file);
                $deleted++;
            }
        }

        $this->info("Selesai. {$deleted} file temp lebih tua dari {$hours} jam dihapus.");

        return self::SUCCESS;
    }
}
