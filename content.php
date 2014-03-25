<article <?php post_class(); ?>>
	<?php get_template_part( 'inc/jumbotron' ); ?>
	<?php do_action( 'wm_before_content' ); ?>
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-md-8 col-md-offset-2">
				<?php the_content(); ?>
				<?php wm_link_pages(); ?>
			</div>
		</div>
	</div>
</article>
