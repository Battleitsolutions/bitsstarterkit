<?php
/**
 * Functions to provide support for the One Click Demo Import plugin (wordpress.org/plugins/one-click-demo-import)
 *
 * @package bits
 */


/**
 * Set import files
 */
function bits_set_import_files() {
    return array(

        array(
            'import_file_name'           => 'bits',
            'import_file_url'            => 'https://battleitsolutions.com/wp-content/uploads/demo-content/bits/bits-content.xml',
            'import_widget_file_url'     => 'https://battleitsolutions.com/wp-content/uploads/demo-content/bits/bits-widgets.wie',
            'import_customizer_file_url' => 'https://battleitsolutions.com/wp-content/uploads/demo-content/bits/bits-customizer.dat',
            'import_preview_image_url'   => 'https://battleitsolutions.com/wp-content/uploads/agency-hero-thumb.png',
            'preview_url'                => 'https://demo.battleitsolutions.com/bits-agency',
        ),
        array(
            'import_file_name'           => 'portfolio',
            'import_file_url'            => 'https://battleitsolutions.com/wp-content/uploads/demo-content/bits/bits-dc-startup.xml',
            'import_widget_file_url'     => 'https://battleitsolutions.com/wp-content/uploads/demo-content/bits/bits-w-startup.wie',
            'import_customizer_file_url' => 'https://battleitsolutions.com/wp-content/uploads/demo-content/bits/bits-c-startup.dat',
            'import_preview_image_url'   => 'https://battleitsolutions.com/wp-content/uploads/startup-hero-thumb.png',
            'preview_url'                => 'https://demo.battleitsolutions.com/bits-startup',
        ),
        array(
            'import_file_name'           => 'Business',
            'import_file_url'            => 'https://battleitsolutions.com/wp-content/uploads/demo-content/bits/bits-dc-business2.xml',
            'import_widget_file_url'     => 'https://battleitsolutions.com/wp-content/uploads/demo-content/bits/bits-w-business2.wie',
            'import_customizer_file_url' => 'https://battleitsolutions.com/wp-content/uploads/demo-content/bits/bits-c-business2.dat',
            'import_preview_image_url'   => 'https://battleitsolutions.com/wp-content/uploads/business2-hero-thumb.png',
            'preview_url'                => 'https://demo.battleitsolutions.com/bits-business2',
        ),            
        array(
            'import_file_name'           => 'Health coach',
            'import_file_url'            => 'https://battleitsolutions.com/wp-content/uploads/demo-content/bits/bits-dc-health.xml',
            'import_widget_file_url'     => 'https://battleitsolutions.com/wp-content/uploads/demo-content/bits/bits-w-health.wie',
            'import_customizer_file_url' => 'https://battleitsolutions.com/wp-content/uploads/demo-content/bits/bits-c-health.dat',
            'import_preview_image_url'   => 'https://battleitsolutions.com/wp-content/uploads/health-hero-demo.png',
            'import_notice'              => __( 'Please install the LearnPress plugin before importing this demo', 'bits' ),
            'preview_url'                => 'https://demo.battleitsolutions.com/bits-health-coach',
        ),
        array(
            'import_file_name'           => 'Lawyer',
            'import_file_url'            => 'https://battleitsolutions.com/wp-content/uploads/demo-content/bits/bits-dc-lawyer.xml',
            'import_widget_file_url'     => 'https://battleitsolutions.com/wp-content/uploads/demo-content/bits/bits-w-lawyer.wie',
            'import_customizer_file_url' => 'https://battleitsolutions.com/wp-content/uploads/demo-content/bits/bits-c-lawyer.dat',
            'import_preview_image_url'   => 'https://battleitsolutions.com/wp-content/uploads/lawyer-hero-demo.jpg',
            'preview_url'                => 'https://demo.battleitsolutions.com/bits-lawyer',
        ),        
    );
}
add_filter( 'pt-ocdi/import_files', 'bits_set_import_files' );

/**
 * Define actions that happen after import
 */
function bits_set_after_import_mods() {

	//Assign the menu
    $main_menu = get_term_by( 'name', 'Menu', 'nav_menu' );
    set_theme_mod( 'nav_menu_locations', array(
            'primary' => $main_menu->term_id,
        )
    );

    //Asign the static front page and the blog page
    $front_page = get_page_by_title( 'Home' );
    $blog_page  = get_page_by_title( 'Blog' );

    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page -> ID );
    update_option( 'page_for_posts', $blog_page -> ID );

    //Assign the Front Page template
    update_post_meta( $front_page -> ID, '_wp_page_template', 'page-templates/template_page-builder.php' );

}
add_action( 'pt-ocdi/after_import', 'bits_set_after_import_mods' );

/**
* Remove branding
*/
add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );