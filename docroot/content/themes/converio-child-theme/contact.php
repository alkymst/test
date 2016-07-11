<?php
/*
* Template name: Contact page
*/
get_header();
?>
<section class="content <?php echo esc_attr($converio_sidebar_class); ?>">
	<?php 
		$hide_title = get_post_meta(get_the_id(), 'hide_title', true);
	?>
<div class="contact">
	<article class="main single contact">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<?php if(!$hide_title) : ?>
			<h1><?php the_title(); ?></h1>
			<?php endif; ?>
			<?php the_content(); ?>
			<?php wp_link_pages(array('before' => '<p class="pages"><strong>'.esc_attr__('Pages', 'converio').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>

		<?php endwhile; endif; ?>
	</article>
	<aside>
		<?php if (function_exists('dynamic_sidebar')) { dynamic_sidebar('contact-sidebar'); } ?>
	</aside>
</div>
</section>
<?php get_footer(); ?>