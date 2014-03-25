<?php

require_once( get_template_directory() . '/lib/bootstrap-navwalker.php' );

class WM_Theme
{
	public static function setup()
	{
		add_action( 'admin_init', array( __CLASS__, 'admin_init' ) );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_scripts' ) );

		add_filter( 'form_fields', array( __CLASS__, 'form_fields' ), 10, 2 );
		add_filter( 'get_the_date', array( __CLASS__, 'get_the_date' ) );
		add_filter( 'protected_title_format', array( __CLASS__, 'protected_title_format' ) );
		add_filter( 'the_password_form', array( __CLASS__, 'the_password_form' ) );

		register_nav_menus( array(
			'navbar' => __( 'Top Navbar', 'wm-theme' ),
			'footer' => __( 'Footer Pills', 'wm-theme' )
		) );
		add_theme_support( 'post-thumbnails' );
		// add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );
		add_post_type_support( 'page', 'excerpt' );
	}

	public static function admin_init()
	{
		if ( class_exists( 'WM_Less' ) ) {
			register_less_variables( get_template_directory() . '/less/variables.less' ),
			less_import( array(
				'less/bootstrap.less',
				'less/theme.less',
				'less/wordpress.less',
				'less/webmaestro.less'
			) );
		}
	}

	public static function enqueue_scripts()
	{
		wp_enqueue_style( 'fonts', 'http://fonts.googleapis.com/css?family=Lobster+Two:400,700|Open+Sans:300,800|Open+Sans+Condensed:700' );
		wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js' );
		wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/vendor/bootstrap.min.js', array( 'jquery' ), null, true );
		wp_enqueue_script( 'wm-plugins', get_template_directory_uri() . '/js/plugins.js', array( 'jquery' ), null, true );
		wp_enqueue_script( 'webmaestro', get_template_directory_uri() . '/js/main.js', array( 'jquery', 'wm-plugins' ), null, true );
	}

	public static function form_fields( $content, $fields )
	{
		$bp = "sm"; // Breakpoint
		$l_col = 6; // Labels column
		$c_col = 6; // Controls column
		$content = "<div class='form-horizontal'>";
    foreach ( $fields as $name => $field ) {
			$attrs = "name='{$name}'" . ( $field['required'] ? ' required' : '' );
			$label = "<label for='form-{$name}' class='col-{$bp}-{$l_col} control-label'>{$field['label']}</label>";
			$ph = esc_attr( $field['label'] );
    	$content .= "<div class='form-group'>";
    	switch ( $field['type'] )
			{
		    case 'checkbox':
		        $content .= "<div class='col-{$bp}-offset-{$l_col} col-{$bp}-{$c_col}'><div class='checkbox'>";
		        $content .= "<label><input {$attrs} type='checkbox' value='1' /> {$field['label']}</label>";
		        $content .= "</div></div>";
		        break;

		    case 'textarea':
		        $content .= $label;
		        $content .= "<div class='col-{$bp}-{$c_col}'><textarea {$attrs} placeholder='{$ph}' id='form-{$name}' class='form-control' rows='5'></textarea></div>";
		        break;

		    case 'radio':
		        $content .= "<label class='col-{$bp}-{$l_col} control-label'>{$field['label']}</label>";
		        $content .= "<p class='col-{$bp}-{$c_col}'>";
		        foreach ( $field['options'] as $k => $opt ) {
		        	$content .= "<span class='radio'><label><input type='radio' {$attrs} value='$k'> {$opt}</label></span>";
		        }
		        $content .= "</p>";
		        break;

		    case 'select':
		        $content .= $label;
		        $content .= "<div class='col-{$bp}-{$c_col}'><select {$attrs} id='form-{$name}' class='form-control'>";
		        foreach ( $field['options'] as $k => $opt ) {
		        	$content .= "<option value='$k'>{$opt}</option>";
		        }
		        $content .= "</select></div>";
		        break;

				case 'submit':
					$content .= "<div class='col-{$bp}-offset-{$l_col} col-{$bp}-{$c_col}'>
						<button type='submit' class='btn btn-primary btn-lg'>{$field['label']}</button>
					</div>";
					break;

		    default:
		        $content .= $label;
		        $content .= "<div class='col-{$bp}-{$c_col}'><input {$attrs} placeholder='{$ph}' id='form-{$name}' type='{$field['type']}' class='form-control' /></div>";
		        break;
			}
			$content .= "</div>";
		}
		return $content . "</div>";
	}

	public static function protected_title_format( $protected ) {
		if ( post_password_required() ) {
			return __( '<span class="glyphicon glyphicon-lock"></span> %s' );
		} else {
			return __( '%s' );
		}
	}

	public static function the_password_form( $content ) {
		$pattern = '/\<p\>\<label (.+)\>(.+)[\:?] \<input (.+)\/\>\<\/label\> \<input (.+)\/\>.?\<\/p\>/';
		$replacement = '<div class="form-horizontal"><div class="form-group"><label class="col-sm-6 control-label" $1>$2</label><div class="col-sm-6"><div class="input-group"><input placeholder="$2" class="form-control" $3/><span class="input-group-btn"><input class="btn btn-default" $4/></div></div></div></div>';
		return preg_replace( $pattern, $replacement, $content );
	}

	public static function get_the_date( $date )
	{
		if ( $timestamp = strtotime( $date ) ) {
			$dif = time() - $timestamp;
			$time = array(
		    's'	=> 60,	// 60 seconds in 1 minute
		    'i'	=> 60,	// 60 minutes in 1 hour
		    'h'	=> 24,	// 24 hours in 1 day
		    'd'	=> 7,	// 7 days in 1 week
		    'w'	=> 4,	// 4 weeks in 1 month
		    'm'	=> 12,	// 12 months in 1 year
		    'y'	=> 10	// Up to 10 years...
			);
			foreach( $time as $unit => $length ) {
		    if( $dif < $length ) {
		    	switch ( $unit ) {
		    		case 's':
		    			// return sprintf( _n( '1 second ago', '%s seconds ago', $dif, 'wm-theme' ), $dif );
		    		case 'i':
		    			// return sprintf( _n( '1 minute ago', '%s minutes ago', $dif, 'wm-theme' ), $dif );
		    		case 'h':
		    			// return sprintf( _n( '1 hour ago', '%s hours ago', $dif, 'wm-theme' ), $dif );
							return __( 'Today', 'wm-theme' );
		    		case 'd':
		    			return sprintf( _n( 'Yesterday', '%s days ago', $dif, 'wm-theme' ), $dif );
		    		case 'w':
		    			return sprintf( _n( '1 week ago', '%s weeks ago', $dif, 'wm-theme' ), $dif );
		    		case 'm':
		    			return sprintf( _n( '1 month ago', '%s months ago', $dif, 'wm-theme' ), $dif );
		    		case 'y':
		    			return sprintf( _n( '1 year ago', '%s years ago', $dif, 'wm-theme' ), $dif );
		    	}
		    }
		    $dif = round( $dif / $length );
			}
		}
    return $date;
	}
}
add_action( 'after_setup_theme', array( WM_Theme, 'setup' ) );

function wm_get_archive_title()
{
	if ( is_home() && $page_id = get_option( 'page_for_posts' ) ) {
		$title = get_the_title( $page_id );
	} elseif ( is_category() || is_tag() || is_tax() ) {
		$title = single_term_title( '', false );
	} elseif ( is_author() ) {
		$title = get_the_author();
	} elseif ( is_date() ) {
		$title = get_the_date();
	} elseif ( is_post_type_archive() ) {
		$title = post_type_archive_title( '', false );
	} elseif ( is_search() ) {
		$title = '“' . get_search_query() . '”';
	} else {
		$title = __( 'Archives', 'wm-theme' );
	}
	return apply_filters( 'the_title', $title );
}

function wm_get_archive_content()
{
	if ( is_home() && $page_id = get_option( 'page_for_posts' ) ) {
		$content = get_post_field( 'post_content', $page_id );
	} elseif ( is_category() || is_tag() || is_tax() ) {
		$content = term_description();
	} elseif ( is_author() ) {
		$content = get_the_author_meta( 'description' );
	} else {
		return false;
	}
	return apply_filters( 'the_content', $content );
}

function wm_get_archive_thumbnail( $size = 'medium', $attr = null )
{
	if ( is_home() && $page_id = get_option( 'page_for_posts' ) ) {
		$thumbnail = get_post_thumbnail_id( $page_id );
	} elseif ( class_exists( WM_Plugin ) ) {
		// TODO : Add support for "Terms Thumbnail" ...
		if ( is_author() && $profile = get_the_author_meta( 'profile' ) ) {
			$thumbnail = $profile['picture'];
		} else {
			return false;
		}
	} else {
		return false;
	}
	return wp_get_attachment_image( $thumbnail, $size, false, $attr );
}

function wm_link_pages() {
	global $page, $multipage, $numpages;
	if ( $multipage ) {
		$output = '<ul class="pagination">';
		for ( $i = 1; $i < ( $numpages + 1 ); $i = $i + 1 ) {
			$output .= ( ( $i == $page ) ? '<li class="active"><a href="#">' : '<li>' . _wp_link_page( $i ) ) . $i . '</a></li>';
		}
		echo $output . '</ul>';
	}
}
