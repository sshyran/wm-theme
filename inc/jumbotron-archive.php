<article class="jumbotron">
	<div class="container">
		<div class="row">
			<?php if ( $thumbnail = wm_get_archive_thumbnail( 'medium', array( 'class' => 'img-rounded img-responsive aligncenter' ) ) ) { ?>
				<div class="col-xs-8 col-xs-offset-2 col-md-4 col-md-offset-1">
					<?php echo $thumbnail; ?>
				</div>
			<?php } ?>
			<div class="col-xs-12 <?php if ( $thumbnail ) {
					echo "col-md-6 col-md-offset-1 col-lg-5";
				} else {
					echo "col-md-8 col-md-offset-2";
				} ?>">
				<header>
					<h1><?php echo wm_get_archive_title(); ?></h1>
				</header>
				<?php echo wm_get_archive_content(); ?>
			</div>
		</div>
	</div>
</article>
