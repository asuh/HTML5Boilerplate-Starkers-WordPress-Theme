<?php

/* Begin Boilerplate Admin */

/* End Boilerplate Plug-in */

// custom admin login logo for child theme
function child_custom_login_logo() {
	echo '<style type="text/css">
	h1 a { background-image: url('.get_bloginfo('stylesheet_directory').'/images/custom-login-logo.png) !important; }
	</style>';
}
add_action('login_head', 'child_custom_login_logo');

?>