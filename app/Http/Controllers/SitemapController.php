<?php

namespace App\Http\Controllers;

use App\Helpers\SeoHelper;
use App\Models\Legality;
use App\Models\Lokasi;
use App\Models\Lokasiooh;
use App\Models\Portofolio;
use App\Models\PortofolioCategory;
use App\Models\Service;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Schema;

class SitemapController extends Controller
{
    /**
     * Generate concise, valid XML sitemap containing only canonical published URLs.
     */
    public function index(): Response
    {
        $urls = [];

        // 1. Homepage
        $urls[] = [
            'loc' => SeoHelper::getCanonicalUrl('/'),
            'lastmod' => now()->format('Y-m-d'),
            'changefreq' => 'daily',
            'priority' => '1.0',
        ];

        // 2. Layanan Utama Periklanan (DOOH & OOH)
        $latestDooh = null;
        try {
            if (Schema::hasTable('lokasis')) {
                $latestDooh = Lokasi::latest('updated_at')->value('updated_at');
            }
        } catch (\Throwable $e) {}

        $urls[] = [
            'loc' => SeoHelper::getCanonicalUrl(route('periklanan.show', 'advertising-dooh')),
            'lastmod' => ($latestDooh ?? now())->format('Y-m-d'),
            'changefreq' => 'weekly',
            'priority' => '0.9',
        ];

        $latestOoh = null;
        try {
            if (Schema::hasTable('lokasioohs')) {
                $latestOoh = Lokasiooh::latest('updated_at')->value('updated_at');
            }
        } catch (\Throwable $e) {}

        $urls[] = [
            'loc' => SeoHelper::getCanonicalUrl(route('periklanan.show', 'advertising-ooh')),
            'lastmod' => ($latestOoh ?? now())->format('Y-m-d'),
            'changefreq' => 'weekly',
            'priority' => '0.9',
        ];

        // 3. Layanan Publik Lainnya yang Terbit
        $services = collect();
        try {
            if (Schema::hasTable('services')) {
                $services = Service::whereNotNull('endpoint')
                    ->where('endpoint', '!=', '')
                    ->whereNotIn('endpoint', ['advertising-dooh', 'advertising-ooh'])
                    ->get();
            }
        } catch (\Throwable $e) {}

        foreach ($services as $service) {
            $urls[] = [
                'loc' => SeoHelper::getCanonicalUrl(route('services.show', $service->endpoint)),
                'lastmod' => ($service->updated_at ?? now())->format('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ];
        }

        // 4. Portofolio & Kategori Portofolio Terbit
        $latestPorto = null;
        try {
            if (Schema::hasTable('portofolios')) {
                $latestPorto = Portofolio::latest('updated_at')->value('updated_at');
            }
        } catch (\Throwable $e) {}

        $urls[] = [
            'loc' => SeoHelper::getCanonicalUrl(route('portofolio')),
            'lastmod' => ($latestPorto ?? now())->format('Y-m-d'),
            'changefreq' => 'weekly',
            'priority' => '0.8',
        ];

        $categories = collect();
        try {
            if (Schema::hasTable('portofolio_categories')) {
                $categories = PortofolioCategory::whereNotNull('endpoint')
                    ->where('endpoint', '!=', '')
                    ->get();
            }
        } catch (\Throwable $e) {}

        foreach ($categories as $cat) {
            $urls[] = [
                'loc' => SeoHelper::getCanonicalUrl(route('portofolio.list', $cat->endpoint)),
                'lastmod' => ($cat->updated_at ?? now())->format('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.7',
            ];
        }

        // 5. Discover (Katalog Media)
        $urls[] = [
            'loc' => SeoHelper::getCanonicalUrl(route('discover')),
            'lastmod' => now()->format('Y-m-d'),
            'changefreq' => 'weekly',
            'priority' => '0.8',
        ];

        // 6. Legality
        $latestLegality = null;
        try {
            if (Schema::hasTable('legalities')) {
                $latestLegality = Legality::latest('updated_at')->value('updated_at');
            }
        } catch (\Throwable $e) {}

        $urls[] = [
            'loc' => SeoHelper::getCanonicalUrl(route('legalitas')),
            'lastmod' => ($latestLegality ?? now())->format('Y-m-d'),
            'changefreq' => 'monthly',
            'priority' => '0.6',
        ];

        // 7. Contact
        $urls[] = [
            'loc' => SeoHelper::getCanonicalUrl(route('contact')),
            'lastmod' => now()->format('Y-m-d'),
            'changefreq' => 'monthly',
            'priority' => '0.7',
        ];

        return response()->view('sitemap', compact('urls'), 200)
            ->header('Content-Type', 'text/xml; charset=UTF-8');
    }

    /**
     * Dynamic robots.txt route (fallback and testable).
     */
    public function robots(): Response
    {
        $sitemapUrl = SeoHelper::getCanonicalUrl('/sitemap.xml');

        $content = "User-agent: *\n"
            . "Allow: /\n"
            . "Disallow: /admin\n"
            . "Disallow: /dashboard\n"
            . "Disallow: /login\n"
            . "Disallow: /register\n"
            . "Disallow: /profile\n"
            . "Disallow: /lang/\n"
            . "Disallow: /clear-cache\n\n"
            . "Sitemap: {$sitemapUrl}\n";

        return response($content, 200)
            ->header('Content-Type', 'text/plain; charset=UTF-8');
    }
}
