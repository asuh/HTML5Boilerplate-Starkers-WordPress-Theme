<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Boilerplate
 * @since Boilerplate 1.0
 */
?><!DOCTYPE html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js ie6"><![endif]-->
<!--[if IE 7]>	 <html <?php language_attributes(); ?> class="no-js ie7"><![endif]-->
<!--[if IE 8]>	 <html <?php language_attributes(); ?> class="no-js ie8"><![endif]-->
<!--[if gt IE 8]><!--><html <?php language_attributes(); ?> class="no-js"> <!--<![endif]-->
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />

		<title><?php
			/*
			 * Print the <title> tag based on what is being viewed.
			 * We filter the output of wp_title() a bit -- see
			 * boilerplate_filter_wp_title() in functions.php.
			 */
			wp_title( '|', true, 'right' );
		?></title>

		<!-- CSS : implied media="all" -->
		<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

		<?php
		/* Always have wp_head() just before the closing </head>
		 * tag of your theme, or you will break many plugins, which
		 * generally use this hook to add elements to <head> such
		 * as styles, scripts, and meta tags.
		 */
		wp_head();
?>
	</head>
	<body <?php body_class(); ?>>
		<header role="banner">
			<?php $heading_tag = ( is_home() || is_front_page() ) ? 'h1' : 'div'; ?><<?php echo $heading_tag; ?> id="logo">
				<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
					<span>
						<?php bloginfo( 'name' ); ?>
					</span>
					<img src="<?php bloginfo('stylesheet_directory'); ?>/img/logo.png" width="xxx" height="xxx" alt="Logo Description" title="Site Title" />
					<!-- Remove img tag above if logo is not an image -->
				</a>
			</<?php echo $heading_tag; ?>>
			<div id="description"><?php bloginfo( 'description' ); ?></div>
		</header><!-- end header -->
		<nav id="access" role="navigation">
		  <?php /*  Allow screen readers / text browsers to skip the navigation menu and get right to the good stuff */ ?>
			<a href="#content" title="<?php esc_attr_e( 'Skip to content', 'boilerplate' ); ?>"><?php _e( 'Skip to content', 'boilerplate' ); ?></a>
			<?php /* Our navigation menu.  If one isn't filled out, wp_nav_menu falls back to wp_page_menu.  The menu assiged to the primary position is the one used.  If none is assigned, the menu with the lowest ID is used.  */ ?>
			<?php wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary' ) ); ?>
		</nav><!-- #access -->
		<div id="content" role="main">
