		<footer class="jumbotron">
			<div class="container">
				<div class="row">
					<p class="col-xs-6">&copy; <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="brand-name"><?php echo apply_filters( 'brand_name', get_bloginfo( 'name' ) ); ?></a></p>

<?php wp_nav_menu( array(
    'theme_location'    => 'footer',
    'depth'             => 2,
    'container'         => 'nav',
    'container_class'	=> 'col-xs-6',
    'menu_class'        => 'nav nav-pills pull-right',
    'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
    'walker'            => new wp_bootstrap_navwalker()
) ); ?>

				</div>
			</div>
		</footer>

<?php wp_footer(); ?>

		</body>
</html>
