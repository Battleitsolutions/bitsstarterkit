<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package bits
 */

?>

	</div><!-- #content -->

	<?php
		if ( !is_page_template( 'page-templates/template_page-builder.php') ) {
			echo 	'</div>';
			echo '</div>';
		}
	?>

	<?php get_sidebar( 'footer' ); ?>

	<footer id="colophon" class="site-footer">
		<div class="container">
			<div class="row">
				<?php do_action( 'bits_footer' ); ?>
			</div>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
