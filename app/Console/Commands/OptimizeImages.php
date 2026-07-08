<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Partner;
use App\Models\Heroe;
use App\Models\Service;
use Illuminate\Support\Facades\Storage;
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
    protected $description = 'Optimize existing partner images and the main logo for better performance';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting image optimization...');

        $manager = new ImageManager(new Driver());
        $partners = Partner::all();
        $optimizedCount = 0;

        foreach ($partners as $partner) {
            $oldFilename = $partner->gambar;
            if (!$oldFilename) {
                continue;
            }

            $oldPath = storage_path('app/public/image_partner/' . $oldFilename);
            if (!file_exists($oldPath)) {
                $this->warn("File not found for partner ID {$partner->id}: {$oldFilename}");
                continue;
            }

            // Prevent re-optimizing if already webp and maybe already optimized? 
            // It's safer to just re-optimize and save with a new name or the same webp name.
            try {
                $image = $manager->read($oldPath);
                
                // If it's wider than 400, scale it down
                if ($image->width() > 100) {
                    $image->scaleDown(width: 100);
                }

                $encoded = $image->toWebp(75);
                
                $newFilename = uniqid() . '.webp';
                
                // Save new image
                Storage::disk('public')->put('image_partner/' . $newFilename, (string) $encoded);
                
                // Update DB
                $partner->gambar = $newFilename;
                $partner->save();

                // Delete old image only if it's not the same filename (though uniqid ensures it's different)
                if ($oldFilename !== $newFilename && Storage::disk('public')->exists('image_partner/' . $oldFilename)) {
                    Storage::disk('public')->delete('image_partner/' . $oldFilename);
                }
                
                $this->info("Optimized partner ID {$partner->id}: {$oldFilename} -> {$newFilename}");
                $optimizedCount++;

            } catch (\Exception $e) {
                $this->error("Failed to optimize partner ID {$partner->id}: " . $e->getMessage());
            }
        }

        // Optimize the main logo
        $logoPath = public_path('images/logo-tokabe.png');
        if (file_exists($logoPath)) {
            try {
                $image = $manager->read($logoPath);
                
                if ($image->width() > 450) {
                    $image->scaleDown(width: 450);
                    // Save it back as PNG to preserve exact transparency format expected by the site
                    $image->save($logoPath);
                    $this->info("Optimized main logo: {$logoPath}");
                } else {
                    $this->info("Main logo is already small enough.");
                }
            } catch (\Exception $e) {
                $this->error("Failed to optimize main logo: " . $e->getMessage());
            }
        }

        // Optimize Hero images
        $heroes = Heroe::all();
        $heroOptimizedCount = 0;

        foreach ($heroes as $hero) {
            $oldFilename = $hero->gambar;
            if (!$oldFilename) continue;

            $oldPath = storage_path('app/public/image_hero/' . $oldFilename);
            if (!file_exists($oldPath)) continue;

            try {
                $image = $manager->read($oldPath);
                
                // Scale down hero images to max 1280px to save space
                if ($image->width() > 1280) {
                    $image->scaleDown(width: 1280);
                }

                // Compress heavily for hero background
                $encoded = $image->toWebp(70);
                
                $newFilename = uniqid() . '.webp';
                
                Storage::disk('public')->put('image_hero/' . $newFilename, (string) $encoded);
                
                $hero->gambar = $newFilename;
                $hero->save();

                if ($oldFilename !== $newFilename && Storage::disk('public')->exists('image_hero/' . $oldFilename)) {
                    Storage::disk('public')->delete('image_hero/' . $oldFilename);
                }
                
                $this->info("Optimized hero ID {$hero->id}: {$oldFilename} -> {$newFilename}");
                $heroOptimizedCount++;
            } catch (\Exception $e) {
                $this->error("Failed to optimize hero ID {$hero->id}: " . $e->getMessage());
            }
        }

        // Optimize Service images
        $services = Service::all();
        $serviceOptimizedCount = 0;

        foreach ($services as $service) {
            $oldFilename = $service->gambar;
            if (!$oldFilename || Str::endsWith($oldFilename, ['.mp4', '.webm', '.ogg'])) continue;

            $oldPath = storage_path('app/public/image_service/' . $oldFilename);
            if (!file_exists($oldPath)) continue;

            try {
                $image = $manager->read($oldPath);
                
                // Scale down service images to max 600px
                if ($image->width() > 600) {
                    $image->scaleDown(width: 600);
                }

                $encoded = $image->toWebp(75);
                
                $newFilename = uniqid() . '.webp';
                
                Storage::disk('public')->put('image_service/' . $newFilename, (string) $encoded);
                
                $service->gambar = $newFilename;
                $service->save();

                if ($oldFilename !== $newFilename && Storage::disk('public')->exists('image_service/' . $oldFilename)) {
                    Storage::disk('public')->delete('image_service/' . $oldFilename);
                }
                
                $this->info("Optimized service ID {$service->id}: {$oldFilename} -> {$newFilename}");
                $serviceOptimizedCount++;
            } catch (\Exception $e) {
                $this->error("Failed to optimize service ID {$service->id}: " . $e->getMessage());
            }
        }

        $this->info("Image optimization completed. Total partners: {$optimizedCount}, Heroes: {$heroOptimizedCount}, Services: {$serviceOptimizedCount}");
    }
}
