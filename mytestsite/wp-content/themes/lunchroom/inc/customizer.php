<?php
/**
 * Lunchroom Theme Customizer
 *
 * @package Lunchroom
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function lunchroom_customize_register( $wp_customize ) {
	
//Add a class for titles
    class lunchroom_info extends WP_Customize_Control {
        public $type = 'info';
        public $label = '';
        public function render_content() {
        ?>
			<h3 style="text-decoration: underline; color: #DA4141; text-transform: uppercase;"><?php echo esc_html( $this->label ); ?></h3>
        <?php
        }
    }
	
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	
	$wp_customize->remove_control('header_textcolor');
	
	$wp_customize->add_setting('color_scheme', array(
		'default' => '#ef4323',
		'sanitize_callback'	=> 'sanitize_hex_color',
	));
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control($wp_customize,'color_scheme',array(
			'label' => __('Color Scheme','lunchroom'),
			'section' => 'colors',
			'settings' => 'color_scheme'
		))
	);
	
	$wp_customize->add_section('headercont_section',array(
		'title'	=> __('Header Contact','lunchroom'),
		'description'	=> __('Add header contact details here','lunchroom'),
		'priority'	=> null
	));
	
	$wp_customize->add_setting('cont_phone',array(
		'default'	=> '+123 4567 890',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	
	$wp_customize->add_control('cont_phone',array(
		'label'	=> __('Add contact number','lunchroom'),
		'section'	=> 'headercont_section',
		'setting'	=> 'cont_phone',
		'type'	=> 'text'
	));	
	
	
	$wp_customize->add_section('footer_section',array(
		'title'	=> __('Footer Text','lunchroom'),
		'description'	=> __('Add some text for footer like copyright etc.','lunchroom'),
		'priority'	=> null
	));
	
	$wp_customize->add_setting('footer_copy',array(
		'default'	=> __('Lunchroom 2015 | All Rights Reserved.','lunchroom'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	
	$wp_customize->add_control('footer_copy',array(
		'label'	=> __('Copyright Text','lunchroom'),
		'section'	=> 'footer_section',
		'type'		=> 'text'
	));
	
	
    $wp_customize->add_section(
        'lunchroom_theme_doc',
        array(
            'title' => __('Documentation &amp; Support', 'lunchroom'),
            'priority' => null,
            'description' => __('For documentation and support check this link :','lunchroom'). '<a href="'.esc_url(lunchroom_theme_doc).'" target="_blank">Lunchroom Documentation</a>',
        )
    );  
	
    $wp_customize->add_setting('lunchroom_options[info]', array(
            'type' => 'info_control',
            'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
        )
    );
	
    $wp_customize->add_control( new lunchroom_info( $wp_customize, 'doc_section', array(
        'section' => 'lunchroom_theme_doc',
        'settings' => 'lunchroom_options[info]',
        'priority' => 10
        ) )
    );
	
	
}
add_action( 'customize_register', 'lunchroom_customize_register' );	

//Integer
function lunchroom_sanitize_integer( $input ) {
    if( is_numeric( $input ) ) {
        return intval( $input );
    }
}

function lunchroom_css(){
		?>
        <style>
				a,
				a:hover, 
				.tm_client strong,
				#footer ul li:hover a, 
				#footer ul li.current_page_item a,
				.postmeta a:hover,
				.call h3,
				.footer-menu ul li a:hover,
				#sidebar ul li a:hover,
				.blog-post h3.entry-title,
				.woocommerce ul.products li.product .price,
				.main-nav ul li a:hover{
					color:<?php echo esc_html(get_theme_mod('color_scheme','#ef4323')); ?>;
				}
				a.blog-more:hover,
				.nav-links span.current, 
				.nav-links a:hover,
				#commentform input#submit,
				input.search-submit,
				.nivo-controlNav a.active,
				.top-right .social-icons a:hover,
				.blog-date .date{
					background-color:<?php echo esc_html(get_theme_mod('color_scheme','#ef4323')); ?>;
				}
		</style>
	<?php }
add_action('wp_head','lunchroom_css');

function lunchroom_custom_customize_enqueue() {
	wp_enqueue_script( 'lunchroom-custom-customize', get_template_directory_uri() . '/js/custom.customize.js', array( 'jquery', 'customize-controls' ), false, true );
}
add_action( 'customize_controls_enqueue_scripts', 'lunchroom_custom_customize_enqueue' );