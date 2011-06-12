<?php

/* Begin Boilerplate Admin */
	require_once(STYLESHEETPATH . '/boilerplate-admin/admin-menu.php');
/* End Boilerplate Plug-in */

// custom admin login logo
function custom_login_logo() {
	echo '<style type="text/css">
	h1 a { background-image: url('.get_bloginfo('stylesheet_directory').'/img/custom-login-logo.png) !important; }
	</style>';
}
add_action('login_head', 'custom_login_logo');

?>