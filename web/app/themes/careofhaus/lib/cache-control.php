<?php
//Cache all pages for 1 week (604800)
add_action( 'send_headers', function() {
    header("Cache-Control: max-age=604800");
});

//Useful to rewrite purge cache requests to main site if Multisite!
//add_filter('vhp_purge_urls', function ($urls, $postId) {
//    $mappedDomain = domain_mapping_siteurl([]);
//    $adminUrl = home_url();
//
//    foreach ($urls as &$url) {
//        $url = str_replace($adminUrl, $mappedDomain, $url);
//    }
//
//    return $urls;
//}, 10, 2);
