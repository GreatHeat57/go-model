<?php echo '<?xml version="1.0" encoding="UTF-8"?>'. PHP_EOL; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($xmls as $xml)
        <url>
            <loc>{{ $xml['loc'] }}</loc>
            <?php /* 
            <lastmod>{{ $xml['lastmod'] }}</lastmod>
            <changefreq>{{ $xml['changefreq'] }}</changefreq>
            <priority>{{ $xml['priority'] }}</priority>
            */ ?>
        </url>
    @endforeach
</urlset>