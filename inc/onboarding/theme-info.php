<?php
/**
 * Theme info page
 *
 * @package bits
 */

//Add the theme page
add_action('admin_menu', 'bits_add_theme_info');
function bits_add_theme_info(){

	if ( !current_user_can('install_plugins') ) {
		return;
	}

	$theme_info = add_theme_page( __('bits Info','bits'), __('bits Info','bits'), 'manage_options', 'bits-info.php', 'bits_info_page' );
	add_action( 'load-' . $theme_info, 'bits_info_hook_styles' );
}

//Callback
function bits_info_page() {
	$user = wp_get_current_user();
?>
	<div class="info-container">
		<p class="hello-user"><?php echo sprintf( __( 'Hello, %s,', 'bits' ), '<span>' . esc_html( ucfirst( $user->display_name ) ) . '</span>' ); ?></p>
		<h1 class="info-title"><?php echo sprintf( __( 'Welcome to bits starter kit version %s', 'bits' ), esc_html( wp_get_theme()->version ) ); ?></h1>
		<p class="welcome-desc"><?php esc_html_e( 'bits starter kit is now installed and ready to go. To help you with the next step, we’ve gathered together on this page all the resources you might need. We hope you enjoy using bits starter theme. ', 'bits' ); ?>
	

		<div class="bits-theme-tabs">

			<div class="bits-tab-nav nav-tab-wrapper">
				<a href="#begin" data-target="begin" class="nav-button nav-tab begin active"><?php esc_html_e( 'Getting started', 'bits' ); ?></a>
				<a href="#actions" data-target="actions" class="nav-button actions nav-tab"><?php esc_html_e( 'Recommended Actions', 'bits' ); ?></a>
				<a href="#support" data-target="support" class="nav-button support nav-tab"><?php esc_html_e( 'Support', 'bits' ); ?></a>

				<a href="#table" data-target="table" class="nav-button table nav-tab"><?php esc_html_e( 'Hire Us', 'bits' ); ?></a>
			</div>

			<div class="bits-tab-wrapper">

				<div id="begin" class="bits-tab begin show">
					<h3><?php esc_html_e( 'Step 1 - Implement recommended actions', 'bits' ); ?></h3>
					<p><?php esc_html_e( 'We\'ve made a list of steps for you to follow to get the most of bits starter kit.', 'bits' ); ?></p>
					<p><a class="actions" href="#actions"><?php esc_html_e( 'Check recommended actions', 'bits' ); ?></a></p>
					<hr>
					<h3><?php esc_html_e( 'Step 2 - Read documentation', 'bits' ); ?></h3>
					<p><?php esc_html_e( 'Our documentation will have you up and running in no time.', 'bits' ); ?></p>
					<p><a href="https://docs.battleitsolutions.com/category/260-bits" target="_blank"><?php esc_html_e( 'Documentation', 'bits' ); ?></a></p>
					<hr>
					<h3><?php esc_html_e( 'Step 3 - Customize', 'bits' ); ?></h3>
					<p><?php esc_html_e( 'Use the Customizer to make bits your own.', 'bits' ); ?></p>
					<p><a class="button button-primary button-large" href="<?php echo admin_url( 'customize.php' ); ?>"><?php esc_html_e( 'Go to Customizer', 'bits' ); ?></a></p>
				</div>

				<div id="actions" class="bits-tab actions">
					<h3><?php esc_html_e( 'Install: Elementor', 'bits' ); ?></h3>
					<p><?php esc_html_e( 'It is highly recommended that you install Elementor. It will enable you to create pages by adding widgets to them using drag and drop.', 'bits' ); ?></p>
					
					<?php if ( !defined( 'ELEMENTOR_PATH' ) ) : ?>
					<?php $so_url = wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=elementor'), 'install-plugin_elementor'); ?>
					<p>
						<a target="_blank" class="install-now button" href="<?php echo esc_url( $so_url ); ?>"><?php esc_html_e( 'Install and Activate', 'bits' ); ?></a>
					</p>
					<?php else : ?>
						<p style="color:#23d423;font-style:italic;font-size:14px;"><?php esc_html_e( 'Plugin installed and active!', 'bits' ); ?></p>
					<?php endif; ?>

					<hr>
					<h3><?php esc_html_e( 'Install: Kirki (theme options)', 'bits' ); ?></h3>
					<p><?php esc_html_e( 'The theme options are built with the awesome Kirki framework. Click to install it.', 'bits' ); ?></p>
					<?php if ( !class_exists('Kirki') ) : ?>
					<?php $st_url = wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=kirki'), 'install-plugin_kirki'); ?>
					<p>
						<a target="_blank" class="install-now button" href="<?php echo esc_url( $st_url ); ?>"><?php esc_html_e( 'Install and Activate', 'bits' ); ?></a>
					</p>
					<?php else : ?>
						<p style="color:#23d423;font-style:italic;font-size:14px;"><?php esc_html_e( 'Plugin installed and active!', 'bits' ); ?></p>
					<?php endif; ?>
					<hr>					
					<h3><?php esc_html_e( 'Demo content', 'bits' ); ?></h3>
					
					<div class="column-wrapper">
						<p><?php esc_html_e( 'Use the button below to import any of our demo sites.', 'bits' ); ?></p>
						<p class="hello"><?php bits_Onboarding::import_button_html( false, '', esc_html__( 'Import a demo site', 'bits' ) ); ?></p>
					</div>
				</div>

				<div id="support" class="bits-tab support">
					<div class="column-wrapper">
						<div class="tab-column">
						<span class="dashicons dashicons-sos"></span>
						<h3><?php esc_html_e( 'Get in touch.', 'bits' ); ?></h3>
						<p><?php esc_html_e( 'Need help? Send us a message.', 'bits' ); ?></p>
							<a href="https://battleitsolutions.com/submitticket.php" target="_blank"><?php esc_html_e( 'Submit a ticket', 'bits' ); ?></a>				
							</div>
						<div class="tab-column">
						<span class="dashicons dashicons-book-alt"></span>
						<h3><?php esc_html_e( 'Documentation', 'bits' ); ?></h3>
						<p><?php esc_html_e( 'Our documentation can help you learn how to use the theme and get the most out of your website.', 'bits' ); ?></p>
						<a href="https://docs.battleitsolutions.com/category/260-bits.php" target="_blank"><?php esc_html_e( 'See the Documentation', 'bits' ); ?></a>
						</div>
					</div>
				</div>

				


				<div id="table" class="bits-tab table">
				<table class="widefat fixed featuresList"> 
				   <thead> 
					<tr> 
					 <td><strong><h3><?php esc_html_e( 'Features', 'bits' ); ?></h3></strong></td>
					</tr> 
				   </thead> 
				   <tbody> 
				   <tr> 
					 <td><?php esc_html_e( 'Elementor support', 'bits' ); ?></td>
					
					</tr> 
					<tr> 
					 <td><?php esc_html_e( 'Access to all Google Fonts plus more', 'bits' ); ?></td>
					 
					</tr> 
					<tr> 
					 <td><?php esc_html_e( 'Responsive Design perfect for all devices', 'bits' ); ?></td>
					
					</tr> 
					<tr> 
					 <td><?php esc_html_e( 'Search Engine Optimized', 'bits' ); ?></td>
					 
					</tr> 
					<tr> 
					 <td><?php esc_html_e( 'Social Media Intergrations', 'bits' ); ?></td>
				
					</tr> 
					<tr> 
					 <td><?php esc_html_e( 'Custom Elementor blocks', 'bits' ); ?></td>
					 
					</tr> 
					<tr> 
					 <td><?php esc_html_e( 'Translation ready for all languages', 'bits' ); ?></td>
					 
					</tr> 
					<tr> 
					 <td><?php esc_html_e( 'Built to match your branding', 'bits' ); ?></td>
					 
					</tr> 
					<tr> 
					 <td><?php esc_html_e( 'Blog intergration', 'bits' ); ?></td>
					
					</tr> 
					<tr> 
					 <td><?php esc_html_e( 'Widgetized footer', 'bits' ); ?></td>
					 
					</tr> 
					<tr> 
					 <td><?php esc_html_e( 'Custom Content', 'bits' ); ?></td>
					 
					</tr> 	
					<td><?php esc_html_e( 'WooCommerce compatible', 'bits' ); ?></td>
					 
					</tr>
					<tr> 
					 <td><?php esc_html_e( 'Higher Conversion Rates', 'bits' ); ?></td>
					 
					</tr> 
					<tr> 
					 <td><?php esc_html_e( 'Footer Credits option', 'bits' ); ?></td>
					 
					</tr> 
					<tr> 
					 <td><?php esc_html_e( 'Stock Images', 'bits' ); ?></td>
					 
					</tr> 
					<tr> 
					 <td><?php esc_html_e( 'Certified Technicians on Call 24 hours', 'bits' ); ?></td>
					 
					</tr> 
					<tr> 
					 <td><?php esc_html_e( 'Year of Free Website Hosting', 'bits' ); ?></td>
					 
					</tr> 
					<tr> 
					 <td><?php esc_html_e( 'Completely Custom layouts (list, masonry)', 'bits' ); ?></td>
					 
					</tr> 
					<tr> 
					 <td><?php esc_html_e( 'Extended WooCommerce options', 'bits' ); ?></td>
					 
					</tr> 
					<tr> 
					 <td><?php esc_html_e( 'Priority support', 'bits' ); ?></td>
					 
					</tr> 
				   </tbody> 
				  </table>
				  <p style="text-align: right;"><a class="button button-primary button-large" href="https://webdesign.battleitsolutions.com"><?php esc_html_e('Hire Us To Build It ', 'bits'); ?></a></p>
				</div>		
			</div>
		</div>
	</div>
<?php
}

//Styles
function bits_info_hook_styles(){
	add_action( 'admin_enqueue_scripts', 'bits_info_page_styles' );
}
function bits_info_page_styles() {
	wp_enqueue_style( 'bits-info-style', get_template_directory_uri() . '/inc/onboarding/assets/css/info-page.css', array(), true );

	wp_enqueue_script( 'bits-info-script', get_template_directory_uri() . '/inc/onboarding/assets/js/info-page.js', array('jquery'),'', true );

}