<?php get_header();

if ( have_posts() ) {
	if ( is_singular() ) {
		the_post();
		get_template_part( 'content', get_post_type() );
	} else {
		get_template_part( 'inc/jumbotron', 'archive' ); ?>
		<main class="container">
			<div class="row tiles">
				<?php while ( have_posts() ) {
					the_post();
					get_template_part( 'excerpt', get_post_type() );
				} ?>
			</div>
		</main>
	<?php }
} else {
	get_template_part( 'none' );
} ?>

<?php get_footer(); ?>
