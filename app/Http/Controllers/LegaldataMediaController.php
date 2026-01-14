<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;

class LegaldataMediaController extends Controller
{
    public function image(Request $request)
    {
        $source = (string) $request->query('u', '');
        if ($source === '') {
            abort(404);
        }

        // Basic SSRF protection: only allow legaldata.mn images.
        $parts = parse_url($source);
        $host = strtolower((string) ($parts['host'] ?? ''));
        $scheme = strtolower((string) ($parts['scheme'] ?? ''));

        $allowedHosts = ['legaldata.mn', 'www.legaldata.mn'];
        if (!in_array($host, $allowedHosts, true) || !in_array($scheme, ['http', 'https'], true)) {
            abort(404);
        }

        $path = (string) ($parts['path'] ?? '');
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        $allowedExt = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        if (!in_array($ext, $allowedExt, true)) {
            // Fall back to jpg if the URL has no extension.
            $ext = 'jpg';
        }

        $hash = sha1($source);
        $cacheDir = public_path('cache/ld-img');
        $cachePath = $cacheDir . DIRECTORY_SEPARATOR . $hash . '.' . $ext;

        if (File::exists($cachePath)) {
            return response()->file($cachePath, [
                'Cache-Control' => 'public, max-age=31536000, immutable',
            ]);
        }

        File::ensureDirectoryExists($cacheDir);

        $resp = Http::timeout(20)
            ->retry(2, 250)
            ->withHeaders([
                'User-Agent' => 'Mozilla/5.0',
                'Accept' => 'image/avif,image/webp,image/apng,image/*,*/*;q=0.8',
                'Referer' => 'https://legaldata.mn/',
            ])
            ->get($source);

        if (!$resp->ok()) {
            abort(404);
        }

        $contentType = strtolower((string) $resp->header('Content-Type'));
        if (!str_starts_with($contentType, 'image/')) {
            abort(404);
        }

        $body = (string) $resp->body();

        // Avoid caching unexpectedly large files.
        if (strlen($body) > 6 * 1024 * 1024) {
            return response($body, 200)
                ->header('Content-Type', $contentType)
                ->header('Cache-Control', 'public, max-age=3600');
        }

        File::put($cachePath, $body);

        return response($body, 200)
            ->header('Content-Type', $contentType)
            ->header('Cache-Control', 'public, max-age=31536000, immutable');
    }
}
