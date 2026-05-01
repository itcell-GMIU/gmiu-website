<?php
// Set your sitemap URL here (or pass via GET param like ?url=https://example.com/sitemap.xml)
$sitemapUrl = $_GET['url'] ?? 'https://gmiu.edu.in/gmiu/website/sitemap.xml';

if (!filter_var($sitemapUrl, FILTER_VALIDATE_URL)) {
    die("Invalid or missing sitemap URL.");
}

// Fetch the sitemap
$sitemapXml = @file_get_contents($sitemapUrl);
if (!$sitemapXml) {
    die("Failed to load sitemap.");
}

// Parse the XML
$xml = simplexml_load_string($sitemapXml);
if (!$xml) {
    die("Invalid XML format.");
}

// Prepare CSV
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="sitemap-urls.csv"');

$output = fopen('php://output', 'w');
fputcsv($output, ['URL']); // CSV header

// Support both <urlset> and nested <sitemapindex> sitemaps
function extractUrls($xml, $output)
{
    foreach ($xml as $node) {
        if (isset($node->loc)) {
            $url = (string) $node->loc;
            fputcsv($output, [$url]);
        }
    }
}

if ($xml->getName() === 'urlset') {
    extractUrls($xml->url, $output);
} elseif ($xml->getName() === 'sitemapindex') {
    foreach ($xml->sitemap as $sitemap) {
        $nestedSitemapUrl = (string) $sitemap->loc;
        $nestedXml = simplexml_load_file($nestedSitemapUrl);
        if ($nestedXml && $nestedXml->getName() === 'urlset') {
            extractUrls($nestedXml->url, $output);
        }
    }
} else {
    die("Unrecognized sitemap format.");
}

fclose($output);
exit;
