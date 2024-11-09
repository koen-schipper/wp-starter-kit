<?php

if ( ! function_exists( 'whitelabelwp_setup' ) ) :

    define( 'THEME_VERSION', '1.0.0(' . time() . ')' );

    /**
     * Sets up theme defaults and registers support for various
     * WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme
     * hook, which runs before the init hook. The init hook is too late
     * for some features, such as indicating support post thumbnails.
     */
    function whitelabelwp_setup() {

        /**
         * Check if the current PHP version is supported
         */
        if (version_compare(phpversion(), '8.0.0', '<=')) {
            echo 'This theme requires PHP 8.0.0 or higher. You are running ' . phpversion() . '. Please upgrade you PHP version.';
            exit;
        }
        /**
         * Make theme available for translation.
         * Translations can be placed in the /languages/ directory.
         */
        load_theme_textdomain( 'vzero', get_template_directory() . '/languages' );

        /**
         * Add default posts and comments RSS feed links to <head>.
         */
        add_theme_support( 'automatic-feed-links' );

        /**
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
        add_theme_support( 'title-tag' );

        /**
         * Enable support for post thumbnails and featured images.
         */
        add_theme_support( 'post-thumbnails' );

        /**
         * Add support for two custom navigation menus.
         */
        register_nav_menus( array(
                                'primary'   => __( 'Primary Menu', 'vzero' ),
                                'secondary' => __( 'Secondary Menu', 'vzero' ),
                            ) );

        /**
         * Enable support for the following post formats:
         * aside, gallery, quote, image, and video
         */
        add_theme_support( 'post-formats', array( 'aside', 'gallery', 'quote', 'image', 'video' ) );
    }
endif;
add_action( 'after_setup_theme', 'whitelabelwp_setup' );

/**
 * Enqueue scripts and styles.
 */
function whitelabelwp_scripts() {
    wp_enqueue_style( 'whitelabelwp-style', get_stylesheet_uri(), array(), THEME_VERSION );

    wp_enqueue_script( 'whitelabelwp-js', get_template_directory_uri() . '/dist/js/bundle.js', array(), THEME_VERSION, true );
    wp_enqueue_script( 'whitelabelwp-head-js', get_template_directory_uri() . '/dist/js/bundle-head.js', array(), THEME_VERSION, false );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'whitelabelwp_scripts' );

add_action('admin_enqueue_scripts', static function () {
    wp_enqueue_script('whitelabelwp-admin-js', get_template_directory_uri().'/dist/js/bundle-admin.js', array(),
        THEME_VERSION, true);
    wp_enqueue_style('custom_wp_admin_css', get_template_directory_uri().'/admincss.css', false, THEME_VERSION);
    add_editor_style(get_template_directory_uri().'/admincss.css');
});

foreach ( glob(get_template_directory() . '/inc/*.php') as $inc ) {
    require $inc;
}