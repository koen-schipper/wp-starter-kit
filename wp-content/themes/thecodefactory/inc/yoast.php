<?php
/**
 * Yoast options
 */


/**
 * Move Yoast to bottom in admin
 */
function yoast_to_bottom() {
	return 'low';
}
add_filter( 'wpseo_metabox_prio', 'yoast_to_bottom');


/**
 * Add Yoast SEO sitemap to virtual robots.txt file
 */
function yoast_seo_sitemap_to_robotstxt_function( $output ) {
    $options = get_option( 'wpseo_xml' );
    if( empty( $options ) ) {
        return $output;
    }
    if ( class_exists( 'WPSEO_Sitemaps' ) && $options['enablexmlsitemap'] == true ) {
        $homeURL = get_home_url();
        $output .= "Sitemap: $homeURL/sitemap_index.xml\n";
    }
    return $output;
}
add_filter( 'robots_txt', 'yoast_seo_sitemap_to_robotstxt_function', 9999, 1 );