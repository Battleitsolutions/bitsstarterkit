<?php
/**
 * Template part for Menu style 2
 *
 * @package bits
 */
?>

<header id="masthead" class="site-header">
	
	<div class="<?php echo esc_attr( bits_menu_container() ); ?>">
		<div class="row">
			<div class="site-branding col-md-4 col-sm-6 col-9">
				<?php bits_site_branding(); ?>
			</div><!-- .site-branding -->

			<div class="header-mobile-menu col-md-8 col-sm-6 col-3">
				<button class="mobile-menu-toggle" aria-controls="primary-menu">
					<span class="mobile-menu-toggle_lines"></span>
					<span class="sr-only"><?php esc_html_e( 'Toggle mobile menu', 'bits' ); ?></span>
				</button>
			</div>

			<nav id="site-navigation" class="main-navigation col-md-8">
				<?php
					wp_nav_menu( array(
						'theme_location' => 'menu-1',
						'menu_id'        => 'primary-menu',
					) );
				?>

				<?php bits_header_cart_search(); ?>
			</nav><!-- #site-navigation -->

		</div>
	</div>
	<div class="header-search-form">
		<?php get_search_form(); ?>
	</div>	

</header><!-- #masthead -->