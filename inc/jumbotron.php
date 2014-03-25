<header class="jumbotron">
	<div class="container">
		<div class="row">
			<?php if ( ! get_query_var( 'page' ) && $thumbnail = get_the_post_thumbnail( get_the_id(), 'medium', array(
					'class' => 'img-rounded img-responsive aligncenter'
				) ) ) { ?>
				<div class="col-xs-8 col-xs-offset-2 col-md-4 col-md-offset-1">
					<?php echo $thumbnail; ?>
				</div>
			<?php } ?>
			<div class="col-xs-12 <?php if ( $thumbnail ) {
					echo "col-md-6 col-md-offset-1 col-lg-5";
				} else {
					echo "col-md-8 col-md-offset-2";
				} ?>">
				<h1><?php the_title(); ?></h1>
				<?php if ( $excerpt = get_post_field( 'post_excerpt', get_the_id() ) ) {
					echo apply_filters( 'the_excerpt', $excerpt );
					do_action( 'wm_call_to_action' );
					wm_link_pages();
				} ?>
			</div>
		</div>
	</div>
</header>
