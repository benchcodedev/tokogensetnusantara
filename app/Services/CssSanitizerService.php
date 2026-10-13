<?php

namespace App\Services;

class CssSanitizerService
{
    /**
     * Sanitasi dan validasi CSS yang dihasilkan AI (Tingkat B)
     *
     * @param string|null $css
     * @param string $scopeSelector
     * @return array [bool $isValid, string|null $sanitizedCss, string|null $errorReason]
     */
    public static function sanitize(?string $css, string $scopeSelector = '.invitation-wrapper'): array
    {
        if (empty($css) || trim($css) === '') {
            return [true, null, null];
        }

        // 1. Cek tag HTML atau JavaScript injection
        if (preg_match('/<script|<\/script|<style|<\/style|<iframe/i', $css)) {
            return [false, null, 'CSS mengandung tag HTML atau JavaScript yang tidak diizinkan.'];
        }

        // 2. Tolak @import
        if (preg_match('/@import\s+/i', $css)) {
            return [false, null, 'Penggunaan @import dilarang demi keamanan dan stabilitas sistem.'];
        }

        // 3. Tolak url() ke domain eksternal (http, https, //)
        if (preg_match('/url\s*\(\s*[\'"]?\s*(https?:|\/\/)[^\'")]+[\'"]?\s*\)/i', $css)) {
            return [false, null, 'Penggunaan url() ke domain luar dilarang. Hanya url lokal atau data URI yang diizinkan.'];
        }

        // 4. Tolak javascript: pseudo-protocol dan CSS expression
        if (preg_match('/javascript\s*:/i', $css)) {
            return [false, null, 'Protokol javascript: di dalam CSS dilarang.'];
        }

        if (preg_match('/expression\s*\(|behavior\s*:|-moz-binding\s*:/i', $css)) {
            return [false, null, 'Ekspresi script dinamis (expression/behavior) di dalam CSS dilarang.'];
        }

        // 5. Scoping CSS agar hanya memengaruhi wrapper undangan
        $scopedCss = self::scopeCss($css, $scopeSelector);

        return [true, $scopedCss, null];
    }

    /**
     * Membungkus setiap selector CSS agar ter-scope ke container undangan
     */
    protected static function scopeCss(string $css, string $scope): string
    {
        // Pisahkan blok aturan CSS
        $output = [];
        $rules = explode('}', $css);

        foreach ($rules as $rule) {
            $rule = trim($rule);
            if (empty($rule)) continue;

            $parts = explode('{', $rule, 2);
            if (count($parts) !== 2) {
                continue;
            }

            $selectors = explode(',', $parts[0]);
            $properties = $parts[1];

            $scopedSelectors = [];
            foreach ($selectors as $sel) {
                $sel = trim($sel);
                if (empty($sel)) continue;

                // Jika at-rules (misal @keyframes, @media) pertahankan
                if (str_starts_with($sel, '@')) {
                    $scopedSelectors[] = $sel;
                } elseif (str_starts_with($sel, $scope)) {
                    $scopedSelectors[] = $sel;
                } else {
                    $scopedSelectors[] = "{$scope} {$sel}";
                }
            }

            $output[] = implode(', ', $scopedSelectors) . " {\n    " . trim($properties) . "\n}";
        }

        return implode("\n\n", $output);
    }
}
