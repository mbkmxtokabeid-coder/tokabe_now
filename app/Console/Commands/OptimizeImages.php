<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class OptimizeImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'optimize:images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Optimize and compress existing storage images for maximum PageSpeed performance';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        ini_set('memory_limit', '512M');
        $this->info('Starting PageSpeed image optimization...');

        $manager = new ImageManager(new Driver());
        $totalFiles = 0;
        $totalBytesSaved = 0;

        // 1. Hero images (Target: max 1440px width, quality 70)
        $this->info('Optimizing Hero Images...');
        $res = $this->optimizeDirectory($manager, 'image_hero', 1440, 70);
        $totalFiles += $res['count'];
        $totalBytesSaved += $res['saved'];

        // 2. About images (Target: max 600px width, quality 75)
        $this->info('Optimizing About Images...');
        $res = $this->optimizeDirectory($manager, 'image_about', 600, 75);
        $totalFiles += $res['count'];
        $totalBytesSaved += $res['saved'];

        // 3. Service images (Target: max 600px width, quality 75)
        $this->info('Optimizing Service Images...');
        $res = $this->optimizeDirectory($manager, 'image_service', 600, 75);
        $totalFiles += $res['count'];
        $totalBytesSaved += $res['saved'];

        // 4. Partner logos (Target: max 200px width, quality 75)
        $this->info('Optimizing Partner Logos...');
        $res = $this->optimizeDirectory($manager, 'image_partner', 200, 75);
        $totalFiles += $res['count'];
        $totalBytesSaved += $res['saved'];

        // 5. Locations DOOH / OOH (Target: max 800px width, quality 75)
        $this->info('Optimizing Location DOOH & OOH Images...');
        $res = $this->optimizeDirectory($manager, 'image_lokasi', 800, 75);
        $totalFiles += $res['count'];
        $totalBytesSaved += $res['saved'];

        $res = $this->optimizeDirectory($manager, 'image_lokasiooh', 800, 75);
        $totalFiles += $res['count'];
        $totalBytesSaved += $res['saved'];

        // 6. Main logo in public/images
        $logoPath = public_path('images/logo-tokabe.png');
        if (file_exists($logoPath)) {
            try {
                $origSize = filesize($logoPath);
                $img = $manager->read($logoPath);
                if ($img->width() > 450) {
                    $img->scaleDown(width: 450);
                    $img->save($logoPath);
                    $newSize = filesize($logoPath);
                    if ($newSize < $origSize) {
                        $saved = $origSize - $newSize;
                        $totalBytesSaved += $saved;
                        $totalFiles++;
                        $this->line("  ✓ public/images/logo-tokabe.png: " . round($origSize / 1024, 1) . " KB -> " . round($newSize / 1024, 1) . " KB");
                    }
                }
            } catch (\Exception $e) {
                // Ignore
            }
        }

        $savedKb = round($totalBytesSaved / 1024, 1);
        $savedMb = round($totalBytesSaved / (1024 * 1024), 2);

        $this->info("==========================================");
        $this->info("Image optimization completed successfully!");
        $this->info("Total images optimized: {$totalFiles}");
        $this->info("Total bandwidth saved: {$savedKb} KB ({$savedMb} MB)");
        $this->info("==========================================");

        return Command::SUCCESS;
    }

    /**
     * Optimize all images in a storage subdirectory in-place.
     */
    protected function optimizeDirectory(ImageManager $manager, string $subDir, int $maxWidth, int $quality): array
    {
        $dirPath = storage_path('app/public/' . $subDir);
        if (!is_dir($dirPath)) {
            return ['count' => 0, 'saved' => 0];
        }

        $files = scandir($dirPath);
        $count = 0;
        $totalSaved = 0;

        foreach ($files as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            // Skip videos, gifs, or non-image extensions
            if (Str::endsWith(strtolower($file), ['.gif', '.mp4', '.webm', '.ogg', '.gitkeep', '.gitignore'])) {
                continue;
            }

            $filePath = $dirPath . '/' . $file;
            if (!is_file($filePath)) {
                continue;
            }

            try {
                $originalSize = filesize($filePath);
                $image = $manager->read($filePath);

                $modified = false;
                if ($image->width() > $maxWidth) {
                    $image->scaleDown(width: $maxWidth);
                    $modified = true;
                }

                $encoded = (string) $image->toWebp($quality);
                $newSize = strlen($encoded);

                // Save in-place if size was reduced or resolution was scaled down
                if ($newSize < $originalSize || $modified) {
                    file_put_contents($filePath, $encoded);
                    $saved = max(0, $originalSize - $newSize);
                    $totalSaved += $saved;
                    $count++;
                    $this->line("  ✓ {$subDir}/{$file}: " . round($originalSize / 1024, 1) . " KB -> " . round($newSize / 1024, 1) . " KB (Saved " . round($saved / 1024, 1) . " KB)");
                }

                unset($image, $encoded);
                gc_collect_cycles();
            } catch (\Exception $e) {
                // Ignore files that cannot be processed by image driver
            }
        }

        return ['count' => $count, 'saved' => $totalSaved];
    }
}
