<?php 

    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'title-tag' );

    function btg_register_assets() {
        wp_enqueue_style( 'btg-style', get_template_directory_uri(  ) . '/css/style.css', 1.0);
        wp_enqueue_style( 'gotham-fronts', "https://fonts.cdnfonts.com/css/gotham", 1.0);
        wp_enqueue_script('vue', 'https://unpkg.com/vue@3', array(), 1.0);
        wp_enqueue_script( 'btg-script', get_template_directory_uri() . '/js/script.js', array(  ), '1.0', true );
    }
    add_action( 'wp_enqueue_scripts', 'btg_register_assets' );

add_filter( 'show_admin_bar', '__return_false' );

if (function_exists('acf_add_options_page')) {
    acf_add_options_page( array(
        'page_title' => 'Options générales',
        'menu_title' => 'Options générales',
        'menu_slug' => 'options-generales',
        'capability' => 'edit_posts',
        'redirect' => false,
        'position' => '2'
    ) );
}

// Remove contact Form 7 auto p
add_filter('wpcf7_autop_or_not', '__return_false');