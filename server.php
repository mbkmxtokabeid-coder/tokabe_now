<?php

/**
 * Laravel Local Development Server Router
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? ''
);

// Auto-fetch missing media assets from production for /storage/
if (str_starts_with($uri, '/storage/')) {
    $filePath = __DIR__ . '/public' . $uri;
    if (!file_exists($filePath) || is_dir($filePath)) {
        $liveUrl = 'https://tokabe.id' . $uri;
        $ctx = stream_context_create([
            'http' => ['timeout' => 8],
            'ssl'  => ['verify_peer' => false, 'verify_peer_name' => false]
        ]);
        $data = @file_get_contents($liveUrl, false, $ctx);
        if ($data !== false && strlen($data) > 0) {
            $dir = dirname($filePath);
            if (!is_dir($dir)) {
                @mkdir($dir, 0755, true);
            }
            @file_put_contents($filePath, $data);
        }
    }
}

// Serve static assets directly from public/ folder with proper mime types
if ($uri !== '/' && file_exists(__DIR__.'/public'.$uri) && !is_dir(__DIR__.'/public'.$uri)) {
    header('Access-Control-Allow-Origin: *');
    $filePath = __DIR__.'/public'.$uri;
    $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
    
    $mimeTypes = [
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif',
        'webp' => 'image/webp',
        'svg' => 'image/svg+xml',
        'ico' => 'image/x-icon',
        'css' => 'text/css',
        'js' => 'application/javascript',
        'json' => 'application/json',
        'woff' => 'font/woff',
        'woff2' => 'font/woff2',
        'ttf' => 'font/ttf',
    ];

    if (isset($mimeTypes[$extension])) {
        header('Content-Type: ' . $mimeTypes[$extension]);
    } else {
        $mime = mime_content_type($filePath);
        if ($mime) {
            header('Content-Type: ' . $mime);
        }
    }

    readfile($filePath);
    exit;
}

// Forward all non-static route requests to Laravel index.php
require_once __DIR__.'/public/index.php';
