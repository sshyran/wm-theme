<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
	<head>
		<title><?php echo get_bloginfo('name'); wp_title(); ?></title>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1">

<?php wp_head(); ?>

	</head>
	<body <?php body_class(); ?>>

<?php get_template_part( 'inc/navbar' ); ?>
