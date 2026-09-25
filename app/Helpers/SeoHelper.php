<?php

namespace App\Helpers;

class SeoHelper
{
    /**
     * Generate target-rich SEO alt text for images based on type, title, and region.
     *
     * @param string $type
     * @param string $nameOrTitle
     * @param string|null $region
     * @return string
     */
    public static function getImageAlt($type, $nameOrTitle, $region = null)
    {
        if (is_array($nameOrTitle)) {
            $nameOrTitle = $nameOrTitle[app()->getLocale()] ?? $nameOrTitle['id'] ?? $nameOrTitle['en'] ?? current($nameOrTitle) ?? '';
        }
        $nameOrTitle = trim(strip_tags((string) $nameOrTitle));

        if (is_array($region)) {
            $region = $region[app()->getLocale()] ?? $region['id'] ?? $region['en'] ?? current($region) ?? '';
        }
        $region = $region ? trim(strip_tags((string) $region)) : '';
        
        // Normalize type
       
        if (is_array($type)) {
            $type = $type[app()->getLocale()] ?? $type['id'] ?? $type['en'] ?? current($type) ?? '';
        }
        $type = strtolower(trim(strip_tags((string) $type)));
        // 1. VIDEOTRON / DOOH
        if (str_contains($type, 'videotron') || str_contains($type, 'dooh')) {
            $keywords = [
                'Sewa videotron Medan',
                'Harga videotron Medan per bulan',
                'LED display advertising Medan',
                'Videotron strategis Medan',
                'Iklan videotron Medan murah',
                'Sewa LED screen Medan',
                'Jasa videotron outdoor Medan'
            ];
            
            // Check specific locations in Medan
            if (stripos($nameOrTitle, 'Gatot Subroto') !== false) {
                $specific = 'Billboard Jl. Gatot Subroto Medan';
            } elseif (stripos($nameOrTitle, 'SIB') !== false || stripos($nameOrTitle, 'Sudirman') !== false) {
                $specific = 'Billboard Simpang SIB Medan';
            } elseif (stripos($nameOrTitle, 'Sun Plaza') !== false) {
                $specific = 'Billboard Sun Plaza Medan';
            } elseif (stripos($nameOrTitle, 'Putri Hijau') !== false) {
                $specific = 'Videotron Jalan Putri Hijau Medan';
            } elseif (stripos($nameOrTitle, 'Ringroad') !== false) {
                $specific = 'Billboard Ringroad Medan';
            } elseif (stripos($nameOrTitle, 'Glugur') !== false) {
                $specific = 'Iklan Simpang Glugur Medan';
            } else {
                // Return a hash or select based on string length to make it deterministic
                $index = strlen($nameOrTitle) % count($keywords);
                $specific = $keywords[$index];
            }
            
            return "Layanan Videotron DOOH Tokabe.id - {$nameOrTitle} - {$specific}";
        }
        
        // 2. BILLBOARD / OOH / BALIHO
        if (str_contains($type, 'billboard') || str_contains($type, 'ooh') || str_contains($type, 'baliho') || str_contains($type, 'site')) {
            $keywords = [
                'Jasa sewa billboard Medan',
                'Harga sewa billboard Medan',
                'Titik billboard strategis Medan',
                'Sewa baliho Medan murah',
                'Pasang iklan billboard Medan',
                'Billboard Lintas Sumatera'
            ];
            
            // Regional mapping
            if (stripos($region, 'Binjai') !== false || stripos($nameOrTitle, 'Binjai') !== false) {
                $regKey = 'Iklan luar ruang Binjai';
            } elseif (stripos($region, 'Asahan') !== false || stripos($nameOrTitle, 'Asahan') !== false) {
                $regKey = 'Reklame Asahan Sumatera Utara';
            } elseif (stripos($region, 'Tebing Tinggi') !== false || stripos($nameOrTitle, 'Tebing Tinggi') !== false) {
                $regKey = 'Billboard Tebing Tinggi';
            } elseif (stripos($region, 'Deli Serdang') !== false || stripos($nameOrTitle, 'Deli Serdang') !== false) {
                $regKey = 'Sewa billboard Deli Serdang';
            } else {
                $index = strlen($nameOrTitle) % count($keywords);
                $regKey = $keywords[$index];
            }
            
            return "Sewa Reklame Billboard Tokabe.id - {$nameOrTitle} - {$regKey}";
        }
        
        // 3. EVENT ORGANIZER / BRAND ACTIVITY
        if (str_contains($type, 'event') || str_contains($type, 'brand') || str_contains($type, 'eo') || str_contains($type, 'organizer')) {
            $keywords = [
                'Event Organizer Medan terbaik',
                'Jasa EO Medan profesional',
                'Vendor IT event Medan',
                'Fun Run technology Indonesia',
                'Registrasi online event lari Medan',
                'Sistem manajemen peserta event',
                'Sewa laptop Medan untuk event',
                'Technical support event Medan'
            ];
            
            $index = strlen($nameOrTitle) % count($keywords);
            $kw = $keywords[$index];
            return "Event Organizer & Brand Activation Tokabe.id - {$nameOrTitle} - {$kw}";
        }
        
        // 4. PHOTOGRAPHY / VIDEOGRAPHY
        if (str_contains($type, 'photo') || str_contains($type, 'video') || str_contains($type, 'camera')) {
            return "Jasa Videografi & Fotografi Profesional Tokabe.id - {$nameOrTitle} - Dokumentasi Event & Marketing Campaign";
        }
        
        // Default fallbacks
        return "Jasa Periklanan OOH DOOH & Event Organizer Tokabe.id - {$nameOrTitle} - Reklame Medan Sumatera Utara";
    }
}
