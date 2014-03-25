<header class="navbar navbar-default navbar-static-top">
	<div class="container">
		<div class="navbar-header">

<?php
	$location_id = 'navbar';
	$locations = get_nav_menu_locations();
	if ( isset( $locations[$location_id] ) ) {
		$menus = wp_get_nav_menus();
		foreach ( $menus as $menu ) {
			if ( $menu->term_id == $locations[ $location_id ] ) {
				echo "<button type='button' class='navbar-toggle' data-toggle='collapse' data-target='.navbar-collapse'>{$menu->name}</button>";
				break;
			}
		}
	}
?>

			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="navbar-brand">
				<h1><?php echo apply_filters( 'brand_name', get_bloginfo( 'name' ) ); ?></h1>
			</a>
		</div>

<?php wp_nav_menu( array(
    'theme_location'    => $location_id,
    'depth'             => 2,
    'container'         => 'nav',
    'container_class'   => 'collapse navbar-collapse',
    'menu_class'        => 'nav navbar-nav navbar-right',
    'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
    'walker'            => new wp_bootstrap_navwalker()
) ); ?>

	</div>
</header>
