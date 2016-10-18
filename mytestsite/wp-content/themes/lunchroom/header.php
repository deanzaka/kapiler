 <?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Lunchroom
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
		<div id="header">
            <div class="container">	
				<div class="row">
                    <div class="col-md-4">
						<div class="logo">
                        	<?php if ( function_exists( 'the_custom_logo' ) ) {
											the_custom_logo();
									} else { ?>
									<a href="<?php echo esc_url(home_url('/')); ?>"><h1><?php esc_attr(bloginfo('name')); ?></h1></a>
									<p><?php esc_attr(bloginfo('description')); ?></p>
                                    <?php } ?>
						</div>
                    </div>
					<div class="col-md-8">
						<div class="call">
                        	<?php if(get_theme_mod('cont_phone',true) != '') { ?>
							<h3><i class="fa fa-phone"></i><?php echo esc_attr(get_theme_mod('cont_phone','+123 4567 890'));?></h3>
                            <?php } ?>
						</div>
						<div class="clearfix"></div>
						<div class="toggle">
							<a class="toggleMenu" href="#"><?php _e('Menu','lunchroom'); ?></a>
						</div> 
						<div class="main-nav">
							<?php wp_nav_menu( array('theme_location'  => 'primary') ); ?>
						</div>
					</div>
				</div>
            </div>               
		</div><!-- header -->

      <div class="main-container">
         <?php if( function_exists('is_woocommerce') && is_woocommerce() ) { ?>
		 	<div class="content-area">
                <div class="middle-align content_sidebar">
                	<div id="sitemain" class="site-main">
         <?php } ?>