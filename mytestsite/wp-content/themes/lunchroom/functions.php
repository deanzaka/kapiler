<?php
/**
 * Lunchroom functions and definitions
 *
 * @package Lunchroom
 */

if ( ! function_exists( 'lunchroom_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function lunchroom_setup() {

	if ( ! isset( $content_width ) )
		$content_width = 640; /* pixels */

	load_theme_textdomain( 'lunchroom', get_template_directory() . '/languages' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'woocommerce' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'custom-logo' );
	add_image_size('lunchroom-homepage-thumb',240,145,true);
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'lunchroom' ),
		'footer'	=> __('Footer Menu', 'lunchroom'),
	) );
	add_theme_support( 'custom-background', array(
		'default-color' => 'f1f1f1'
	) );
	add_editor_style( 'editor-style.css' );
}
endif; // lunchroom_setup
add_action( 'after_setup_theme', 'lunchroom_setup' );


function lunchroom_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Blog Sidebar', 'lunchroom' ),
		'description'   => __( 'Appears on blog page sidebar', 'lunchroom' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	
	register_sidebar( array(
		'name'          => __( 'Page Sidebar', 'lunchroom' ),
		'description'   => __( 'Appears on page sidebar', 'lunchroom' ),
		'id'            => 'sidebar-2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

}
add_action( 'widgets_init', 'lunchroom_widgets_init' );

function lunchroom_font_url(){
		$font_url = '';
		
		/* Translators: If there are any character that are
		* not supported by Lobster, translate this to off, do not
		* translate into your own language.
		*/
		$lobster = _x('on', 'Lobster font:on or off','lunchroom');
		
		/* Translators: If there are any character that are
		* not supported by Courgette, translate this to off, do not
		* translate into your own language.
		*/
		$courgette = _x('on', 'Courgette font:on or off','lunchroom');
		
		/* Translators: If there are any character that are
		* not supported by Rosario, translate this to off, do not
		* translate into your own language.
		*/
		$rosario = _x('on', 'Rosario font:on or off','lunchroom');
		
		if('off' !== $lobster || 'off' !==  $courgette || 'off' !== $rosario){
			$font_family = array();
			
			if('off' !== $lobster){
				$font_family[] = 'Lobster:300,400,600,700,800,900';
			}
			
			if('off' !== $courgette){
				$font_family[] = 'Courgette:400,700';
			}
			
			if('off' !== $rosario){
				$font_family[] = 'Rosario:400,700';
			}
			
			$query_args = array(
				'family'	=> urlencode(implode('|',$font_family)),
			);
			
			$font_url = add_query_arg($query_args,'//fonts.googleapis.com/css');
		}
		
	return $font_url;
	}
	
function lunchroom_scripts() {
	wp_enqueue_style( 'lunchroom-font', lunchroom_font_url(), array() );
	wp_enqueue_style( 'lunchroom-basic', get_stylesheet_uri() );
	wp_enqueue_style( 'bootstrap', get_template_directory_uri().'/css/bootstrap.css' );
	wp_enqueue_style( 'lunchroom-responsive', get_template_directory_uri().'/css/theme-responsive.css' );
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() .'/js/bootstrap.js', array('jquery') );
	wp_enqueue_script( 'lunchroom-customscripts', get_template_directory_uri() . '/js/custom.js', array('jquery') );
	wp_enqueue_style( 'font-awesome', get_template_directory_uri().'/css/font-awesome.css' );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'lunchroom_scripts' );


/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';


// URL DEFINES
define('lunchroom_pro_theme_url','https://flythemes.net/wordpress-themes/lunchroom-wordpress-theme/');
define('lunchroom_theme_doc','http://flythemesdemo.net/documentation/lunchroom-doc/');
define('lunchroom_site_url','http://flythemes.net/');

function lunchroom_credit_link(){
		return __('Lunchroom theme by','lunchroom'). "<a href=".esc_url(lunchroom_site_url)." target='_blank'> Flythemes</a>";
	}