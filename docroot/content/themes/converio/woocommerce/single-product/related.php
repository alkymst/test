<?php
/**
 * Related Products
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop;

$related = $product->get_related( $posts_per_page );

if ( sizeof( $related ) == 0 ) return;

$args = apply_filters( 'woocommerce_related_products_args', array(
	'post_type'				=> 'product',
	'ignore_sticky_posts'	=> 1,
	'no_found_rows' 		=> 1,
	'posts_per_page' 		=> $posts_per_page,
	'orderby' 				=> $orderby,
	'post__in' 				=> $related,
	'post__not_in'			=> array( $product->id )
) );

$products = new WP_Query( $args );

$woocommerce_loop['columns'] = $columns;
?>

<?php /*share this */
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );?>
<?php if ( is_plugin_active( 'share-this/sharethis.php' ) ) { ?>

<div class="share-post">
		<p class="share-social">
			<?php get_template_part('share-this');?>
		</p>
</div>
<?php } else {
	$share_links = get_theme_mod('share_links');
	if (empty($share_links)) $share_links = 2;
	if($share_links == 2) : 
		get_template_part('share');
	endif;
	} ?>
		
<?php 				

if ( $products->have_posts() ) : ?>

	<div class="related products">

		<h2><?php esc_attr_e( 'Related Products', 'woocommerce' ); ?></h2>

		<?php woocommerce_product_loop_start(); ?>

			<?php while ( $products->have_posts() ) : $products->the_post(); ?>

				<?php wc_get_template_part( 'content', 'product' ); ?>

			<?php endwhile; // end of the loop. ?>

		<?php woocommerce_product_loop_end(); ?>

	</div>

<?php endif;

wp_reset_postdata();
