<?php
/**
 * @package Lunchroom
 * Setup the WordPress core custom header feature.
 *
 * @uses lunchroom_header_style()
 * @uses lunchroom_admin_header_style()

 */
function lunchroom_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'lunchroom_custom_header_args', array(
		//'default-image'          => get_template_directory_uri().'/images/banner_bg.jpg',
		'default-text-color'     => 'fff',
		'width'                  => 1600,
		'height'                 => 400,
		'wp-head-callback'       => 'lunchroom_header_style',
	) ) );
}
add_action( 'after_setup_theme', 'lunchroom_custom_header_setup' );

if ( ! function_exists( 'lunchroom_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see lunchroom_custom_header_setup().
 */
function lunchroom_header_style() {
	?>
	<style type="text/css">
	<?php
		//Check if user has defined any header image.
		if ( get_header_image() ) :
	?>
		#header{
			background: url(<?php echo get_header_image(); ?>) no-repeat;
			background-position: center top;
		}
	<?php endif; ?>	
	</style>
	<?php
}
endif; // lunchroom_header_style

if ( ! function_exists( 'lunchroom_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * @see lunchroom_custom_header_setup().
 */
function lunchroom_admin_header_style() {?>
	<style type="text/css">
	.appearance_page_custom-header #headimg { border: none; }
	</style><?php
}
endif; // lunchroom_admin_header_style


add_action( 'admin_head', 'lunchroom_admin_header_css' );
function lunchroom_admin_header_css(){ ?>
	<style>pre{white-space: pre-wrap;}</style><?php
}