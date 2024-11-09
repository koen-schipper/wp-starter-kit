<?php
if (class_exists( 'woocommerce' )) {
/**
 * Add theme support for woocommerce
 */
add_theme_support( 'woocommerce' );
add_theme_support( 'wc-product-gallery-zoom' );
add_theme_support( 'wc-product-gallery-lightbox' );
add_theme_support( 'wc-product-gallery-slider' );

/**
 * Disable Yoast Schema on product pages
 */
add_filter( 'wpseo_json_ld_output', static function ( $output ) {
    if ( is_product() ) {
        return false;
    }

    return $output;
} );

/**
 * Schema.org for single product
 */
add_action( 'wp_head', 'schema_product' );
function schema_product() {
    global $product;

    if ( is_product() && ! is_a( $product, 'WC_Product' ) ) {
        $product = wc_get_product( get_the_id() );
    }

    if ( is_product() && is_a( $product, 'WC_Product' ) ) :

        ?>
        <script type="application/ld+json">
            {
			  "@context": "http://schema.org",
			  "@type": "Product",
			  "name": "<?php echo esc_attr( $product->get_name() ); ?>",
      "description": "<?php echo esc_attr( $product->get_description() ); ?>",
      "image": "<?php echo get_the_post_thumbnail_url( $product->get_id(), 'full' ); ?>",
      "url": "<?php echo get_permalink( $product->get_id() ); ?>",
      "sku": "<?php echo $product->get_sku(); ?>",
      "brand": "<?php echo $product->get_brand(); ?>",
      "offers": {
        "@type": "Offer",
        "availability": "http://schema.org/<?php echo $product->is_in_stock() ? 'InStock' : 'OutOfStock'; ?>",
        "price": "<?php echo $product->get_price(); ?>",
        "priceCurrency": "<?php echo get_woocommerce_currency(); ?>",
        "url": "<?php echo $product->get_permalink(); ?>"
        }<?php if ( $product->get_reviews_allowed( $context = 'view' ) ) : ?>,
      "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "<?php echo $product->get_average_rating(); ?>",
        "reviewCount": "<?php echo $product->get_review_count(); ?>"
        }
        <?php endif; ?>
            }
        </script>
    <?php
    endif;
}
}