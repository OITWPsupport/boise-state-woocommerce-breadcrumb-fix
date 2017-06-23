<?php
/*
 * Plugin Name: Boise State Woocommerce Breadcrumb Fix
 * Plugin URI: https://github.com/OITWPsupport/boise-state-woocommerce-breadcrumb-fix/releases/latest
 * Description: Allows you to change the text of Woocommerce's root breadcrumb item. 
 * Also adds accessibility fix for buttons.
 * Version: 0.0.3
 * Author: Kira Davis
 */
 
defined( 'ABSPATH' ) or die( 'No hackers' );

//-----------------------------------------------------
// Load Script
//-----------------------------------------------------
/* Uses JQuery to add titles to buttons. */
function load_scripts() {
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'script', plugin_dir_url(__FILE__) . '/script.js', array( 'jquery' ), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'load_scripts' ); 

//-----------------------------------------------------
// Replace Breadcrumb Text
//-----------------------------------------------------
add_filter( 'woocommerce_breadcrumb_defaults', 'woocommerce_filter' );

function woocommerce_filter( $defaults ) {
	if ( get_option('breadcrumb_text') != '') {
		$defaults['home'] = get_option('breadcrumb_text');
	}
	return $defaults;
}

//-----------------------------------------------------
// Admin Page Settings
//-----------------------------------------------------
add_action('admin_menu', 'bsu_breadcrumb_admin_settings');

function bsu_breadcrumb_admin_settings() {
    $page_title = 'Breadcrumbs';
    $menu_title = 'Breadcrumb Settings';
    $capability = 'edit_posts';
    $menu_slug = 'bsu_breadcrumb_options';
    $function = 'bsu_breadcrumb_admin_settings_page_display';
    $icon_url = '';
    $position = 99;

    add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
}

function breadcrumb_text_field() { ?> 
	<input type="text" name="breadcrumb_text" id="breadcrumb_text" value="<?php echo get_option('breadcrumb_text'); ?>" /> 
<?php }

function bsu_breadcrumb_display_theme_panel_fields() {
	add_settings_section("breadcrumb-section", "Breadcrumb Settings", null, "breadcrumb-options");
	add_settings_field("breadcrumb_text", "Breadcrumb Text", "breadcrumb_text_field", "breadcrumb-options", "breadcrumb-section");
	register_setting("breadcrumb-section", "breadcrumb_text");	
}

add_action("admin_init", "bsu_breadcrumb_display_theme_panel_fields");

//-----------------------------------------------------
// Admin Page Display
//-----------------------------------------------------
function bsu_breadcrumb_admin_settings_page_display() {
	// check user capabilities
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die('You do not have sufficient permissions to access this page.');
	}
	?>
	<div class="wrap">
	<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		
		<!-- show error/update messages -->
		<?php settings_errors(); ?>
		
	    <form method="post" action="options.php">
	        <?php
				settings_fields("breadcrumb-section");
				do_settings_sections("breadcrumb-options");      
				submit_button(); 
	        ?>          
		</form>
	</div>
	<?php
}
?>
