<section <?php post_class( is_sticky() ? 'col-sm-12 col-md-8 col-lg-6' : 'col-sm-6 col-md-4 col-lg-3' ); ?>>
<!-- <section <?php post_class( 'col-sm-' . rand( 3, 6 ) ); ?>> -->
	<a href="<?php the_permalink(); ?>" rel="bookmark" class="panel panel-default">
		<header class="panel-heading">
			<h3 class="panel-title"><?php the_title(); ?></h3>
		</header>
		<div class="panel-body">
			<?php if ( has_post_thumbnail() ) {
				the_post_thumbnail( 'medium', array( 'class' => 'img-responsive' ) );
			} ?>
			<?php the_excerpt(); ?>
		</div>
	</a>
</section>
