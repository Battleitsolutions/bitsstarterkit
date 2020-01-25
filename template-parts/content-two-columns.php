<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package bits
 */

$layout 		= bits_blog_layout();
$hide_thumb 	= get_theme_mod( 'index_hide_thumb' );
$hide_date 		= get_theme_mod( 'index_hide_date' );
$hide_cats 		= get_theme_mod( 'index_hide_cats' );
$hide_author 	= get_theme_mod( 'index_hide_author' );
$hide_comments 	= get_theme_mod( 'index_hide_comments' );
$post_class[] = 'col-md-6';
$post_class[] = $layout['type'];
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( implode( ' ', $post_class ) ); ?>>
	<div class="inner">
		<header class="entry-header">
			<?php
			if ( $hide_thumb == '' ) :
				if ( has_post_thumbnail() )
				{
					?>
					<div class="thumbnail<?php echo esc_attr( $layout['item_inner_cols'] ); ?>">
						<?php bits_post_thumbnail(); ?>
						<?php
						if ( $hide_cats == '' ) {
							echo '<span>';
							bits_first_category();
							echo '</span>';
						}
						?>
					</div>
					<?php
				}
			endif;

			?>
		</header><!-- .entry-header -->
		<div class="entry-meta">
			<i class="fa fa-user" aria-hidden="true"></i>
			<?php
			if ( $layout['type'] != 'layout-grid' && $layout['type'] != 'layout-masonry' && $hide_author == '' ) {
				bits_posted_by();
			}
			?>
			<span class="separator">-</span>
			<i class="fa fa-clock-o" aria-hidden="true"></i>
			<?php
			if ( $hide_date == '' ) {
				bits_posted_on();
			}
			?>
		</div><!-- .entry-meta -->
		<?php if ( $layout['type'] != 'layout-grid' && $layout['type'] != 'layout-masonry' ) : ?>
			<?php
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			?>
		<?php endif; ?>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->
