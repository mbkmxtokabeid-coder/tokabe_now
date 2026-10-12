<?php

namespace Tests\Feature;

use Tests\TestCase;

class SitemapTest extends TestCase
{
    /**
     * Test sitemap.xml returns 200 and valid XML.
     */
    public function test_sitemap_returns_200_valid_xml(): void
    {
        $response = $this->get('/sitemap.xml');

        $response->assertStatus(200);
        $this->assertStringContainsString('text/xml', $response->headers->get('Content-Type'));

        $content = $response->getContent();
        $this->assertStringStartsWith('<?xml version="1.0" encoding="UTF-8"?>', trim($content));
        $this->assertStringContainsString('<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">', $content);

        // Parse XML to verify validity
        $xml = simplexml_load_string($content);
        $this->assertNotFalse($xml, 'Sitemap XML is invalid.');
        $this->assertGreaterThan(0, count($xml->url));

        // Ensure canonical URLs are present and on the public domain https://tokabe.id
        foreach ($xml->url as $url) {
            $loc = (string) $url->loc;
            $this->assertNotEmpty($loc);
            $this->assertStringStartsWith('https://tokabe.id', $loc, 'Sitemap URL must use public domain https://tokabe.id: ' . $loc);
            $this->assertStringNotContainsString('?', $loc, 'Sitemap URL should not contain query strings: ' . $loc);
            $this->assertStringNotContainsString('/admin', $loc, 'Sitemap should not contain admin routes: ' . $loc);
            $this->assertStringNotContainsString('/login', $loc, 'Sitemap should not contain login routes: ' . $loc);
        }
    }

    /**
     * Test robots.txt returns 200 and references Sitemap.
     */
    public function test_robots_txt_mentions_sitemap(): void
    {
        $response = $this->get('/robots.txt');

        $response->assertStatus(200);
        $this->assertStringContainsString('text/plain', $response->headers->get('Content-Type'));
        $this->assertStringContainsString('Sitemap: https://tokabe.id/sitemap.xml', $response->getContent());
    }
}
