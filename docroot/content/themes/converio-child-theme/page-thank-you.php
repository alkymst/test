<?php get_header(); ?>
<section class="content <?php echo esc_attr($converio_sidebar_class); ?>">
<?php
$hide_title = get_post_meta(get_the_id(), 'hide_title', true);

$sidebar_position = get_post_meta($converio_thisPageId, 'sidebar_position', true);
if($sidebar_position == 3) $sidebar_position = $converio_sidebar_pos_global;

//if sidebar is set to "don't show"
if($sidebar_position == 2) {
	if (have_posts()) :
		while (have_posts()) : the_post();
			if(!$hide_title) : ?>
				<h2 class="entry-title"><?php the_title(); ?></h2>
			<?php endif;
			the_content();
			wp_link_pages(array('before' => '<p class="pages"><strong>'.esc_attr__('Pages', 'converio').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number'));
			comments_template();
		endwhile;
	endif;
} else {
?>
<section class="main single">
	<?php if (have_posts()) : while (have_posts()) :
		the_post();
	?>
		<article class="page">
			<?php if(!$hide_title) : ?>
				<h2 class="entry-title"><?php the_title(); ?></h2>
			<?php endif; ?>
			<?php the_content(); ?>
			<?php wp_link_pages(array('before' => '<p class="pages"><strong>'.esc_attr__('Pages', 'converio').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
		</article>

		<?php comments_template(); ?>
	<?php endwhile; endif; ?>
</section>
<?php
if($sidebar_position != 2) {
	$sidebar = get_post_meta(get_the_id(), 'custom_sidebar', true) ? get_post_meta(get_the_id(), 'custom_sidebar', true) : "default";
	if($sidebar != 'no') {
		if($sidebar && $sidebar != "default") get_sidebar("custom");
		else get_sidebar();
	}
}
?>
<?php } ?>
 </section>

<!-- Google Code for Form lead Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 944721978;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "zIGpCJ_ZzV0QuqC9wgM";
var google_remarketing_only = false;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/944721978/?label=zIGpCJ_ZzV0QuqC9wgM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>


<!-- Facebook Conversion Code for Leads - 1Fee -->
<script>(function() {
var _fbq = window._fbq || (window._fbq = []);
if (!_fbq.loaded) {
var fbds = document.createElement('script');
fbds.async = true;
fbds.src = '//connect.facebook.net/en_US/fbds.js';
var s = document.getElementsByTagName('script')[0];
s.parentNode.insertBefore(fbds, s);
_fbq.loaded = true;
}
})();
window._fbq = window._fbq || [];
window._fbq.push(['track', '6023117411459', {'value':'0.00','currency':'USD'}]);
</script>
<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?ev=6023117411459&amp;cd[value]=0.00&amp;cd[currency]=USD&amp;noscript=1" /></noscript>


<?php get_footer(); ?>