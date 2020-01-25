<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package bits
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function bits_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	//Menu type
	$menu_layout = bits_menu_layout();
	$classes[] 	= $menu_layout['type'];
	$classes[] 	= $menu_layout['contained'];

	//Sticky menu
	$sticky 	= get_theme_mod('sticky_menu', 'sticky-header');
	$classes[] 	= esc_attr( $sticky );	

	// primary type
	if ( is_home() )
	{
		$layout = bits_blog_layout();
		$classes[] = $layout[ 'type' ];
	}	

	if ( class_exists( 'WooCommerce' ) ) {
		$check = bits_wc_archive_check();
		
		if ( $check ) {
			$classes[] = 'woocommerce-product-loop';
		}
	}

	return $classes;
}
add_filter( 'body_class', 'bits_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function bits_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'bits_pingback_header' );

/**
 * Returns menu type and if the menu is contained or stretched
 */
function bits_menu_layout() {

	//Type
	$type 		= get_theme_mod( 'menu_type', 'menuStyle2' );
	//Contained or stretched
	$contained 	= get_theme_mod( 'menu_container', 'menuNotContained' );	

	$layout = array(
		'type' 		=> $type,
		'contained'	=> $contained,
	);

	return $layout;
}

/**
 * Menu container
 */
function bits_menu_container() {
	$layout = bits_menu_layout();

	if ( 'menuNotContained' === $layout['contained'] ) {
		$container = 'container-fluid';
	} else {
		$container = 'container';
	}

	return $container;
}

/**
 * Menu style 3 (Extended 1) options
 */
function bits_get_extended1_options() {

	$default_social 	= array(
		array(
			'icon'		=> 'fa-facebook',
			'link_url'  => 'https://facebook.com/yourprofile',
		),
		array(
			'icon'		=> 'fa-twitter',			
			'link_url'  => 'https://twitter.com/yourprofile',
		),
	);

	$options = array(
		'cta_text'		=> get_theme_mod( 'x1_cta_text', __( 'Get a quote', 'bits' ) ),
		'cta_url'		=> get_theme_mod( 'x1_cta_url', __( 'http://example.org/contact/', 'bits' ) ),
		'header_social'	=> get_theme_mod( 'x1_header_social', $default_social ),
		'email_address'	=> get_theme_mod( 'x1_email_address', 'office@example.org' ),
		'phone_number'	=> get_theme_mod( 'x1_phone_number', '+333.222.111' ),
	);

	return $options;
}


/**
 * Blog layout
 */
if ( !function_exists( 'bits_blog_layout' ) ) {
	function bits_blog_layout() {

		$layout = get_theme_mod( 'blog_layout', 'layout-default' );

		//Blog archive columns
		if ( $layout == 'layout-grid' || $layout == 'layout-masonry' ) {
			$cols 		= 'col-md-12';
			$sidebar	= false;
		}
		elseif ( $layout == 'layout-list-2' || $layout == 'layout-two-columns' )
		{
			$cols 		= 'col-lg-9';
			$sidebar 	= true;
		}
		else {
			$cols 		= 'col-lg-8';
			$sidebar 	= true;
		}	

		//Inner columns for list layout
		if ( $layout == 'layout-list' ) {
			$item_inner_cols = 'col-md-6 col-sm-12';
		}
		elseif ( $layout == 'layout-list-2' )
		{
			$item_inner_cols = '';
		}
		else {
			$item_inner_cols = 'col-md-12';
		}

		$setup = array(
			'type'				=> $layout,
			'sidebar' 			=> $sidebar,
			'cols'	  			=> $cols,
			'item_inner_cols' 	=> $item_inner_cols
		);
		
		return $setup;

	}
}

/**
 * Single post layout
 */
if ( !function_exists( 'bits_single_layout' ) ) {
	function bits_single_layout() {

		$layout = get_theme_mod( 'single_post_layout', 'layout-default' );

		//Single post columns
		if ( $layout == 'layout-default' ) {
			$cols 		= 'col-lg-8';
			$sidebar	= true;
		} else {
			$cols 		= 'col-md-12';
			$sidebar 	= false;
		}

		$setup = array(
			'type'		=> $layout,
			'sidebar' 	=> $sidebar,
			'cols'	  	=> $cols,
		);
		
		return $setup;

	}
}

/**
 * Adds class for blog grid and masonry layouts
 */
function bits_blog_grid( $classes ) {

	$layout = bits_blog_layout();

	if ( !is_singular() && ( $layout['type'] == 'layout-grid' || $layout['type'] == 'layout-masonry' ) ) {
		$classes[] = 'col-lg-4 col-md-6';
	}

	return $classes;
}
add_filter( 'post_class', 'bits_blog_grid' );

/**
 * Masonry data
 */
function bits_masonry_data() {

	$layout = bits_blog_layout();

	if ( $layout['type'] == 'layout-masonry' ) {
		return 'data-masonry=\'{ "itemSelector": ".hentry", "columnWidth": ".grid-sizer", "percentPosition": "true"}\'';
	}
}

/**
 * Single comment template
 */
function bits_comment_template($comment, $args, $depth) {

	?>
	<li id="comment-<?php comment_ID(); ?>" <?php comment_class( $comment->has_children ? 'parent' : '' ); ?>>
		<article id="div-comment-<?php comment_ID(); ?>" class="comment-body comment-entry clearfix">
			
			<figure class="comment-avatar">
				<?php echo get_avatar( $comment, $args['avatar_size'] ); ?>
			</figure>

			<div class="comment-text">
				<header class="comment-head">
					<time class="comment-time" datetime="<?php comment_time( 'c' ); ?>">
						<?php printf( _x( '%1$s at %2$s', '1: date, 2: time', 'bits' ), get_comment_date(), get_comment_time() ); ?>
					</time>					
					<h5 class="comment-author-name">
						<span><?php printf( '<b class="fn">%s</b>', get_comment_author_link() ) ; ?></span>
					</h5>
				</header>

				<div class="comment-body">
					<?php if ( '0' == $comment->comment_approved ) : ?>
					<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'bits' ); ?></p>
					<?php endif; ?>

					<div class="comment-content">
						<?php comment_text(); ?>
					</div>
					<div class="comment-links">
					<?php edit_comment_link( __( 'Edit', 'bits' ), '<span class="edit-link">', '</span>' ); ?>
					<?php comment_reply_link( array_merge( $args, array( 'add_below' => 'edit-link', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>													
					</div>
				</div>
			</div>
		</article>
	<?php
}

/**
 * Excerpt length
 */
function bits_excerpt_length( $length ) {

	if ( is_admin() ) {
		return $length;
	}

	$excerpt = get_theme_mod('excerpt_length', '20');
	return $excerpt;
}
add_filter( 'excerpt_length', 'bits_excerpt_length', 999 );

/**
 * Footer credits
 */
function bits_footer_credits() {

	$credits = get_theme_mod( 'footer_credits' );
	?>
	
	<div class="site-info col-md-12">
		
		<?php if ( $credits == '' ) : ?>
			<a href="<?php echo esc_url( __( 'https://battleitsolutions.com/', 'bits' ) ); ?>"><?php
				/* translators: %s: CMS name, i.e. WordPress. */
				printf( esc_html__( 'Proudly powered by %s', 'bits' ), 'Battle I.T. Solutions' );
			?></a>
			<span class="sep"> | </span>
			<?php
				/* translators: 1: Theme name, 2: Theme author. */
				printf( esc_html__( 'Theme: %2$s by %1$s.', 'bits' ), 'Emmanuel Battle', '<a href="https://wpthemes.battleitsolutions.com/theme/bits" rel="nofollow">bits</a>' );
			?>
		<?php else : ?>
			<?php echo wp_kses_post( $credits ); ?>
		<?php endif; ?>
	</div><!-- .site-info -->
	
	<?php
}
add_action( 'bits_footer', 'bits_footer_credits' );

/**
 * Tag cloud font sizes
 */
function bits_tag_cloud_widget($args) {
	$args['largest'] = 12;
	$args['smallest'] = 12;
	$args['unit'] = 'px';
	
	return $args;
}
add_filter( 'widget_tag_cloud_args', 'bits_tag_cloud_widget' );

/**
 * Site branding
 */
if ( !function_exists( 'bits_site_branding' ) ) {
	function bits_site_branding() {
		if ( has_custom_logo() ) :
			the_custom_logo();
		else :
			if ( is_front_page() && is_home() ) : ?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<?php else : ?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
			<?php
			endif;

			$description = get_bloginfo( 'description', 'display' );
			if ( $description || is_customize_preview() ) : ?>
				<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
			<?php
			endif;
		endif;
	}
}


if ( ! function_exists( 'bits_header_cart_search' ) ) {
	/**
	 * Display Header cart and search icon.
	 *
	 */
	function bits_header_cart_search() {
		
		$disable_search = get_theme_mod( 'disable_header_search' );
		?>
		<ul class="header-search-cart">
			<?php if ( !$disable_search ) : ?>
			<li class="header-search">
				<div class="header-search-toggle"><a><i class="fa fa-search"></i></a></div>
			</li>
			<?php endif; ?>
			<li class="header-cart-link">
				<?php if ( function_exists( 'bits_woocommerce_cart_link' ) ) {
					bits_woocommerce_cart_link();
				} ?>
			</li>
		</ul>
		<?php
	}
}