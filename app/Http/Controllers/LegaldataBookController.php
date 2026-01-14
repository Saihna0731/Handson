<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class LegaldataBookController extends Controller
{
    public function show(int $id): JsonResponse
    {
        $url = "https://legaldata.mn/book/view/{$id}";

        $response = Http::timeout(15)
            ->retry(2, 250)
            ->withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120 Safari/537.36',
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            ])
            ->get($url);

        if (!$response->ok()) {
            return response()->json([
                'ok' => false,
                'error' => 'Failed to fetch legaldata page',
                'status' => $response->status(),
            ], 502);
        }

        $html = (string) $response->body();

        $doc = new \DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML('<?xml encoding="utf-8" ?>' . $html);
        libxml_clear_errors();

        $xpath = new \DOMXPath($doc);

        $text = function (string $q) use ($xpath): string {
            $node = $xpath->query($q)->item(0);
            if (!$node) return '';
            return trim(preg_replace('/\s+/u', ' ', $node->textContent ?? ''));
        };

        $attr = function (string $q, string $name) use ($xpath): string {
            $node = $xpath->query($q)->item(0);
            if (!$node || !$node->attributes) return '';
            $a = $node->attributes->getNamedItem($name);
            return $a ? (string) $a->nodeValue : '';
        };

        $innerHtml = function (\DOMNode $node) use ($doc): string {
            $out = '';
            foreach ($node->childNodes as $child) {
                $out .= $doc->saveHTML($child);
            }
            return $out;
        };

        $title = $text("//h3[contains(concat(' ', normalize-space(@class), ' '), ' product-title ')]");
        $author = $text("(//div[contains(concat(' ', normalize-space(@class), ' '), ' product-details-info ')]//p//a)[1]");
        $price = $text("//span[contains(concat(' ', normalize-space(@class), ' '), ' price-new ')]");

        $imageHref = $attr("(//div[contains(concat(' ', normalize-space(@class), ' '), ' product-details-slider ')]//a[@data-lightbox])[1]", 'href');
        $imageSrc = $attr("(//div[contains(concat(' ', normalize-space(@class), ' '), ' product-details-slider ')]//img)[1]", 'src');
        $image = $imageHref ?: $imageSrc;

        $meta = [
            'year' => '',
            'pages' => '',
            'category' => '',
            'isbn' => '',
            'lang' => '',
            'size' => '',
        ];

        $rows = $xpath->query("//div[contains(concat(' ', normalize-space(@class), ' '), ' product-details-info ')]//div[contains(concat(' ', normalize-space(@class), ' '), ' mb-4 ')]//div[contains(concat(' ', normalize-space(@class), ' '), ' row ')]");
        foreach ($rows as $row) {
            $cols = [];
            foreach ($row->childNodes as $child) {
                if ($child->nodeType === XML_ELEMENT_NODE) $cols[] = $child;
            }
            if (count($cols) < 2) continue;
            $label = trim(preg_replace('/\s+/u', ' ', $cols[0]->textContent ?? ''));
            $value = trim(preg_replace('/\s+/u', ' ', $cols[1]->textContent ?? ''));

            if (str_starts_with($label, 'Хэвлэгдсэн он')) $meta['year'] = $value;
            else if (str_starts_with($label, 'Хуудасны тоо')) $meta['pages'] = $value;
            else if (str_starts_with($label, 'Ангилал')) $meta['category'] = $value;
            else if (str_starts_with($label, 'ISBN')) $meta['isbn'] = $value;
            else if (str_starts_with($label, 'Хэл')) $meta['lang'] = $value;
            else if (str_starts_with($label, 'Хэмжээ')) $meta['size'] = $value;
        }

        $introNode = $xpath->query("(//article[contains(concat(' ', normalize-space(@class), ' '), ' review-article ')])[1]")->item(0);
        $introHtml = '';
        if ($introNode) {
            $introHtml = $innerHtml($introNode);
            $introHtml = preg_replace('#<h1[^>]*>.*?</h1>#si', '', $introHtml) ?? $introHtml;
        }

        $relatedSlidesHtml = '';
        $relatedSlider = $xpath->query(
            "(//h2[contains(., 'Төсөөтэй') and contains(., 'номууд')]/ancestor::section[1]//div[contains(concat(' ', normalize-space(@class), ' '), ' product-slider ')])[1]"
        )->item(0);
        if ($relatedSlider) {
            $relatedSlidesHtml = $innerHtml($relatedSlider);
        }

        return response()->json([
            'ok' => true,
            'id' => $id,
            'viewUrl' => $url,
            'buyUrl' => "https://legaldata.mn/book/addtocart/{$id}",
            'title' => $title,
            'author' => $author,
            'price' => $price,
            'image' => $image,
            'meta' => $meta,
            'introHtml' => $introHtml,
            'relatedSlidesHtml' => $relatedSlidesHtml,
        ]);
    }
}
