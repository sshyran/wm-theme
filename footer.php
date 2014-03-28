		<footer class="jumbotron">
			<div class="container">
				<div class="row">

<?php wp_nav_menu( array(
    'theme_location'    => 'footer',
    'depth'             => 2,
    'container'         => 'nav',
    'container_class'	=> 'col-xs-6 col-xs-offset-6',
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
