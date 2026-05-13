<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Daftarkan helper sanitasi HTML untuk konten CMS
        // Mencegah XSS meski ada tag HTML yang diizinkan
        \Illuminate\Support\Facades\Blade::directive('safeHtml', function ($expression) {
            return "<?php echo App\\Providers\\AppServiceProvider::sanitizeCmsHtml($expression); ?>";
        });
    }

    /**
     * Sanitasi konten HTML dari CMS.
     * 
     * Hanya izinkan tag & atribut yang aman. Semua event handler (onclick, onmouseover, dsb),
     * atribut href javascript:, dan tag berbahaya akan dihapus.
     *
     * @param string|null $html
     * @return string
     */
    public static function sanitizeCmsHtml(?string $html): string
    {
        if (empty($html)) return '';

        // 1. Tag yang diizinkan
        $allowedTags = '<br><span><strong><b><i><em>';

        // 2. Buang semua tag yang tidak ada di allowlist
        $html = strip_tags($html, $allowedTags);

        // 3. Buang SEMUA atribut berbahaya dari tag yang tersisa
        //    Hanya izinkan atribut "class" yang bersih
        $html = preg_replace_callback(
            '/<(span|strong|b|i|em)(\s[^>]*)?>/',
            function ($matches) {
                $tag = $matches[1];
                $attrs = $matches[2] ?? '';

                // Ambil HANYA atribut class, buang sisanya (onclick, style, on*, href, dll)
                $cleanClass = '';
                if (preg_match('/\bclass\s*=\s*"([^"]*)"/', $attrs, $classMatch)) {
                    // Sanitasi nilai class: hanya huruf, angka, strip, slash, titik, spasi
                    $classValue = preg_replace('/[^a-zA-Z0-9\-_\/\.\s:]/', '', $classMatch[1]);
                    $cleanClass = ' class="' . $classValue . '"';
                }

                return "<{$tag}{$cleanClass}>";
            },
            $html
        );

        return $html;
    }
}
