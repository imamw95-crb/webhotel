<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class OptimizeImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:optimize-images
                           {--dry-run : Scan and report without making changes}
                           {--delete-originals : Delete original JPG/PNG files after WebP conversion}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Optimize existing images: convert to WebP, scale down oversized images';

    /**
     * Image file extensions to process.
     */
    private const IMAGE_EXTENSIONS = ['jpg', 'jpeg', 'png', 'webp'];

    /**
     * Max width for images (larger will be scaled down).
     */
    private const MAX_WIDTH = 1920;

    /**
     * WebP quality (0-100).
     */
    private const WEBP_QUALITY = 80;

    /**
     * Directories to skip entirely.
     */
    private const SKIP_DIRECTORIES = ['logo'];

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $publicPath = Storage::disk('public')->path('');
        $files = File::allFiles($publicPath);
        $processed = 0;
        $skipped = 0;
        $errors = 0;
        $savings = 0;

        $this->components->info('Scanning for images to optimize...');

        $dryRun = $this->option('dry-run');
        $deleteOriginals = $this->option('delete-originals');

        if ($dryRun) {
            $this->components->warn('DRY RUN — no changes will be made.');
        }

        foreach ($files as $file) {
            $relativePath = $file->getRelativePathname();
            $extension = strtolower($file->getExtension());

            // Skip non-image files
            if (! in_array($extension, self::IMAGE_EXTENSIONS, true)) {
                continue;
            }

            // Skip files in excluded directories
            $shouldSkip = false;
            foreach (self::SKIP_DIRECTORIES as $skipDir) {
                if (str_starts_with($relativePath, $skipDir)) {
                    $shouldSkip = true;
                    break;
                }
            }
            if ($shouldSkip) {
                continue;
            }

            // Skip already-optimized WebP files smaller than threshold
            if ($extension === 'webp') {
                if ($file->getSize() < 1024 * 200) { // < 200KB already optimized
                    $skipped++;

                    continue;
                }
                // Re-optimize large WebP files
            }

            try {
                $originalSize = $file->getSize();

                if (! $dryRun) {
                    $image = Image::decodePath($file->getRealPath());
                    $image->scaleDown(width: self::MAX_WIDTH);

                    // Replace extension with .webp
                    $webpPath = preg_replace('/\.('.implode('|', self::IMAGE_EXTENSIONS).')$/i', '.webp', $relativePath);
                    $webpFullPath = Storage::disk('public')->path($webpPath);

                    // Ensure directory exists
                    $dir = dirname($webpFullPath);
                    if (! is_dir($dir)) {
                        mkdir($dir, 0755, true);
                    }

                    $image->save($webpFullPath);
                }

                $newSize = $dryRun ? $originalSize : File::size(Storage::disk('public')->path(
                    preg_replace('/\.('.implode('|', self::IMAGE_EXTENSIONS).')$/i', '.webp', $relativePath)
                ));
                $saving = $originalSize - $newSize;
                $savings += max(0, $saving);

                if ($extension !== 'webp') {
                    // Delete original if option is set
                    if (! $dryRun && $deleteOriginals) {
                        Storage::disk('public')->delete($relativePath);
                    }

                    $this->components->twoColumnDetail(
                        sprintf('<fg=green>✓</> %s', $relativePath),
                        sprintf(
                            '%s → %s (%s)',
                            $this->formatBytes($originalSize),
                            $this->formatBytes($newSize),
                            $saving > 0 ? '<fg=green>-'.$this->formatBytes($saving).'</>' : '<fg=yellow>+0</>'
                        ),
                    );
                } else {
                    $this->components->twoColumnDetail(
                        sprintf('<fg=green>✓</> %s', $relativePath),
                        sprintf(
                            '%s → %s (%s)',
                            $this->formatBytes($originalSize),
                            $this->formatBytes($newSize),
                            $saving > 0 ? '<fg=green>-'.$this->formatBytes($saving).'</>' : '<fg=yellow>no change</>'
                        ),
                    );
                }

                $processed++;
            } catch (\Throwable $e) {
                $this->components->twoColumnDetail(
                    sprintf('<fg=red>✗</> %s', $relativePath),
                    $e->getMessage(),
                );
                $errors++;
            }
        }

        $this->newLine();
        $this->components->info('Summary:');
        $this->components->twoColumnDetail('Processed', sprintf('<fg=green>%d</> images', $processed));
        $this->components->twoColumnDetail('Skipped', sprintf('<fg=yellow>%d</> images (already optimized)', $skipped));
        $this->components->twoColumnDetail('Errors', sprintf('<fg=red>%d</>', $errors));
        $this->components->twoColumnDetail('Total savings', sprintf('<fg=green>%s</>', $this->formatBytes($savings)));
        $this->components->twoColumnDetail('Original files', $deleteOriginals ? '<fg=yellow>deleted</>' : '<fg=green>kept</>');

        if ($dryRun) {
            $this->components->warn('This was a dry run. Run without --dry-run to apply changes.');
        }

        return self::SUCCESS;
    }

    private function formatBytes(int $bytes): string
    {
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 1).' MB';
        }
        if ($bytes >= 1024) {
            return number_format($bytes / 1024, 1).' KB';
        }

        return $bytes.' B';
    }
}
