<?php

/*
 	Begin HTML5 Boilerplate Admin panel.

	There are essentially 5 sections to this:
	1)	Add "HTML5 Boilerplate Admin" link to left-nav Admin Menu & callback function for clicking that menu link
	2)	Add Admin Page CSS if on the Admin Page
	3)	Add "HTML5 Boilerplate Admin" Page options
	4)	Create functions to add above elements to pages
	5)	Add HTML5 Boilerplate options to page as requested
*/

/*	1)	Add "HTML5 Boilerplate" link to left-nav Admin Menu */

	//	Add option if in Admin Page
		function create_boilerplate_admin_page() {
			add_submenu_page('themes.php', 'Boilerplate Admin', 'Boilerplate Admin', 'administrator', 'boilerplate-admin', 'build_boilerplate_admin_page');
		}
		add_action('admin_menu', 'create_boilerplate_admin_page');

	//	You get this if you click the left-column "Boilerplate Admin" (added above)
		function build_boilerplate_admin_page() {
		?>
			<div id="boilerplate-options-wrap">
				<div class="icon32" id="icon-tools"><br /></div>
				<h2>Boilerplate Admin</h2>
				<p>So, there's actually a tremendous amount going on here.  If you're not familiar with <a href="http://html5boilerplate.com/">HTML5 Boilerplate</a> or the <a href="http://starkerstheme.com/">Starkers theme</a> (upon which this theme is based) you should check them out.</p>
				<p>Choose below which options you want included in your site.</p>
				<form method="post" action="options.php" enctype="multipart/form-data">
					<?php settings_fields('plugin_options'); /* very last function on this page... */ ?>
					<?php do_settings_sections('boilerplate-admin'); /* let's get started! */?>
					<p class="submit"><input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" /></p>
				</form>
			</div>
		<?php
		}

/*	2)	Add Admin Page CSS if on the Admin Page */

		function admin_register_head() {
			echo '<link rel="stylesheet" href="'.get_template_directory_uri() . '/boilerplate-admin/style.css" />'.PHP_EOL;
		}
		add_action('admin_head', 'admin_register_head');

/*	3)	Add "Boilerplate Admin" Page options */

	//	Register form elements
		function register_and_build_fields() { 
			register_setting('plugin_options', 'plugin_options', 'validate_setting');
			add_settings_section('main_section', '', 'section_cb', 'boilerplate-admin');
			add_settings_field('chrome', 'Google Chrome / IE-edge?:', 'chrome_setting', 'boilerplate-admin', 'main_section');
			add_settings_field('viewport', '<em><abbr title="iPhone, iTouch, iPad...">iThings</abbr></em> use full zoom?:', 'viewport_setting', 'boilerplate-admin', 'main_section');
			add_settings_field('favicon', 'Got Favicon?:', 'favicon_setting', 'boilerplate-admin', 'main_section');
			add_settings_field('favicon_ithing', 'Got <em><abbr title="iPhone, iTouch, iPad...">iThing</abbr></em> Favicon?', 'favicon_ithing_setting', 'boilerplate-admin', 'main_section');
			add_settings_field('ie_css', 'IE CSS?:', 'ie_css_setting', 'boilerplate-admin', 'main_section');
			add_settings_field('handheld_css', 'Handheld CSS?:', 'handheld_css_setting', 'boilerplate-admin', 'main_section');
			add_settings_field('print_css', 'Print CSS?:', 'print_css_setting', 'boilerplate-admin', 'main_section');
			add_settings_field('modernizr_js', 'Modernizr JS?:', 'modernizr_js_setting', 'boilerplate-admin', 'main_section');
			add_settings_field('jquery_js', 'jQuery JS?:', 'jquery_js_setting', 'boilerplate-admin', 'main_section');
			add_settings_field('plugins_js', 'jQuery Plug-ins JS?:', 'plugins_js_setting', 'boilerplate-admin', 'main_section');
			add_settings_field('site_js', 'Site-specific JS?:', 'site_js_setting', 'boilerplate-admin', 'main_section');
			add_settings_field('belated_png_js', 'Belated PNG JS?:', 'belated_png_js_setting', 'boilerplate-admin', 'main_section');
			add_settings_field('google_analytics_js', 'Google Analytics?:', 'google_analytics_js_setting', 'boilerplate-admin', 'main_section');
		}
		add_action('admin_init', 'register_and_build_fields');

	//	Add Admin Page validation
		function validate_setting($plugin_options) {
			$keys = array_keys($_FILES);
			$i = 0;
			foreach ( $_FILES as $image ) {
				// if a files was upload
				if ($image['size']) {
					// if it is an image
					if ( preg_match('/(jpg|jpeg|png|gif)$/', $image['type']) ) {
						$override = array('test_form' => false);
						// save the file, and store an array, containing its location in $file
						$file = wp_handle_upload( $image, $override );
						$plugin_options[$keys[$i]] = $file['url'];
					} else {
						// Not an image. 
						$options = get_option('plugin_options');
						$plugin_options[$keys[$i]] = $options[$logo];
						// Die and let the user know that they made a mistake.
						wp_die('No image was uploaded.');
					}
				} else { // else, the user didn't upload a file, retain the image that's already on file.
					$options = get_option('plugin_options');
					$plugin_options[$keys[$i]] = $options[$keys[$i]];
				}
				$i++;
			}
			return $plugin_options;
		}

	//	Add Admin Page options
	
	//	in case you need it...
		function section_cb() {}
	
	//	callback fn for chrome
		function chrome_setting() {
			$options = get_option('plugin_options');
			$checked = (isset($options['chrome']) && $options['chrome']) ? 'checked="checked" ' : '';
			echo '<input class="check-field" type="checkbox" name="plugin_options[chrome]" value="true" ' .$checked. '/>';
			echo '<p>Force the most-recent IE rendering engine or users with <a href="http://www.chromium.org/developers/how-tos/chrome-frame-getting-started">Google Chrome Frame</a> installed to see your site using Google Frame.</p>';
			echo '<p>Selecting this option will add the following code to the <code>&lt;head&gt;</code> of your pages:</p>';
			echo '<code>&lt;meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" /&gt;</code>';
		}

	//	callback fn for viewport
		function viewport_setting() {
			$options = get_option('plugin_options');
			$checked = (isset($options['viewport']) && $options['viewport']) ? 'checked="checked" ' : '';
			echo '<input class="check-field" type="checkbox" name="plugin_options[viewport]" value="true" ' .$checked. '/>';
			echo '<p>Force <em><abbr title="iPhone, iTouch, iPad...">iThings</abbr></em> to <a href="http://developer.apple.com/library/safari/#documentation/AppleApplications/Reference/SafariWebContent/UsingtheViewport/UsingtheViewport.html#//apple_ref/doc/uid/TP40006509-SW19">show site at full-zoom</a>, instead of trying to show the entire page.</p>';
			echo '<p>Selecting this option will add the following code to the <code>&lt;head&gt;</code> of your pages:</p>';
			echo '<code>&lt;meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;" /&gt;</code>';
		}

	//	callback fn for favicon
		function favicon_setting() {
			$options = get_option('plugin_options');
			$checked = (isset($options['favicon']) && $options['favicon']) ? 'checked="checked" ' : '';
			echo '<input class="check-field" type="checkbox" name="plugin_options[favicon]" value="true" ' .$checked. '/>';
			echo '<p>If you plan to use a <a href="http://en.wikipedia.org/wiki/Favicon">favicon</a> for your site, place the "favicon.ico" file in the root directory of your site.</p>';
			echo '<p>If the file is in the right location, you don\'t really need to select this option, browsers will automatically look there and no additional code will be added to your pages.</p>';
			echo '<p>Selecting this option will add the following code to the <code>&lt;head&gt;</code> of your pages:</p>';
			echo '<code>&lt;link rel="shortcut icon" href="/favicon.ico" /&gt;</code>';
		}

	//	callback fn for favicon_ithing
		function favicon_ithing_setting() {
			$options = get_option('plugin_options');
			$checked = (isset($options['favicon_ithing']) && $options['favicon_ithing']) ? 'checked="checked" ' : '';
			echo '<input class="check-field" type="checkbox" name="plugin_options[favicon_ithing]" value="true" ' .$checked. '/>';
			echo '<p>To allow <em><abbr title="iPhone, iTouch, iPad...">iThing</abbr></em> users to <a href="http://developer.apple.com/library/safari/#documentation/AppleApplications/Reference/SafariWebContent/ConfiguringWebApplications/ConfiguringWebApplications.html">add an icon for your site to their Home screen</a>, place the "apple-touch-icon.png" file in the root directory of your site.</p>';
			echo '<p>If the file is in the right location, you don\'t really need to select this option, browsers will automatically look there and no additional code will be added to your pages.</p>';
			echo '<p>Selecting this option will add the following code to the <code>&lt;head&gt;</code> of your pages:</p>';
			echo '<code>&lt;link rel="apple-touch-icon" href="/apple-touch-icon.png" /&gt;</code>';
		}

	//	callback fn for ie_css
		function ie_css_setting() {
			$options = get_option('plugin_options');
			$checked = (isset($options['ie_css']) && $options['ie_css']) ? 'checked="checked" ' : '';
			echo '<input class="check-field" type="checkbox" name="plugin_options[ie_css]" value="true" ' .$checked. '/>';
			echo '<p>If you would like to add a IE-specific CSS file, Boilerplate provides a starter file located in:</p>';
			echo '<code>'.get_template_directory_uri() . '/css/ie.css</code>';
			echo '<p><strong>I recommend adding any custom IE-specific CSS to this file and either copying from the starter file or using an <code>@import</code> to add the starter file rather than editing the starter file itself.  This will help to avoid your changes being overwritten during upgrades.</strong></p>';
			echo '<p><strong>And remember</strong>, you don\'t need IE-specific hacks if you activate the IE-Conditional <code>&lt;html&gt;</code> above, because you can target IE specifically by using the IE classes that are being added to <code>&lt;html&gt;</code>.  Sweet!</p>';
			echo '<p>Selecting this option will add the following code to the <code>&lt;head&gt;</code> of your pages:</p>';
			echo '<code>&lt;!--[if IE ]&gt;&lt;link href="'.get_template_directory_uri().'/css/ie.css"&gt;&lt;![endif]--&gt;</code>';
		}

	//	callback fn for handheld_css
		function handheld_css_setting() {
			$options = get_option('plugin_options');
			$checked = (isset($options['handheld_css']) && $options['handheld_css']) ? 'checked="checked" ' : '';
			echo '<input class="check-field" type="checkbox" name="plugin_options[handheld_css]" value="true" ' .$checked. '/>';
			echo '<p>If you would like to add a handheld CSS file, Boilerplate provides a starter file located in:</p>';
			echo '<code>'.get_template_directory_uri() . '/css/handheld.css</code></p>';
			echo '<p>Add what you want to that file and select this option. Here are a <a href="http://thinkvitamin.com/design/make-your-site-mobile-friendly/">couple</a> <a href="http://adactio.com/journal/1700/">resources</a> for making your site mobile-ready, but there are plenty more on the web.</p>';
			echo '<p>Selecting this option will add the following code to the <code>&lt;head&gt;</code> of your pages:</p>';
			echo '<code>&lt;link rel=\'stylesheet\' id=\'handheld-css\'  href=\''.get_template_directory_uri().'/css/handheld.css\' media=\'handheld\' /&gt;</code>';
			echo '<p>(The single quotes and no-longer-necessary attributes are from WP, would like to fix that... maybe next update...)</p>';
			echo '<p><strong>Note: I recommend adding what you want to the starter file and renaming it as above to avoid it being overwritten during upgrades.</strong></p>';
		}

	//	callback fn for print_css
		function print_css_setting() {
			$options = get_option('plugin_options');
			$checked = (isset($options['print_css']) && $options['print_css']) ? 'checked="checked" ' : '';
			echo '<input class="check-field" type="checkbox" name="plugin_options[print_css]" value="true" ' .$checked. '/>';
			echo '<p>If you would like to add a print CSS file, Boilerplate provides a starter file located in:</p>';
			echo '<code>'.get_template_directory_uri() . '/css/print.css</code>';
			echo '<p>Add what you want to that file and select this option. Here are a <a href="http://remysharp.com/2007/05/03/pretty-in-print-tips-for-print-styles/">couple</a> <a href="http://westciv.com/style_master/academycss_tutorial/advanced/printing.html">resources</a> for making your site print-ready, but there are plenty more on the web.</p>';
			echo '<p>Selecting this option will add the following code to the <code>&lt;head&gt;</code> of your pages:</p>';
			echo '<code>&lt;link rel=\'stylesheet\' id=\'print-css\' href=\''.get_template_directory_uri().'/css/print.css\' media=\'print\' /&gt;</code>';
			echo '<p>(The single quotes and no-longer-necessary attributes are from WP, would like to fix that... maybe next update...)</p>';
			echo '<p><strong>Note: Boilerplate\'s style.css does have a few lines of CSS pertaining to print, with a link to <a href="http://www.phpied.com/delay-loading-your-print-css/">this article</a>; your call.</strong></p>';
			echo '<p><strong>Note: I recommend adding what you want to the starter file and renaming it as above to avoid it being overwritten during upgrades.</strong></p>';
		}

	//	callback fn for modernizr_js
		function modernizr_js_setting() {
			$options = get_option('plugin_options');
			$checked = (isset($options['modernizr_js']) && $options['modernizr_js']) ? 'checked="checked" ' : '';
			echo '<input class="check-field" type="checkbox" name="plugin_options[modernizr_js]" value="true" ' .$checked. '/>';
			echo '<p><a href="http://modernizr.com/">Modernizr</a> is a JS library that appends classes to the <code>&lt;html&gt;</code> that indicate whether the user\'s browser is capable of handling advanced CSS, like "no-cssreflections" or "cssreflections".  It\'s a really handy way to apply varying CSS techniques, depending on the user\'s browser\'s abilities.</p>';
			echo '<p>Selecting this option will add the following code to the <code>&lt;head&gt;</code> of your pages (note the lack of a version, when you\'re ready to upgrade, simply copy/paste the new version into the file below, and your site is ready to go!):</p>';
			echo '<code>&lt;script type=\'text/javascript\' src=\''.get_template_directory_uri().'/js/libs/modernizr-1.7.min.js\'&gt;&lt;/script&gt;</code>';
			echo '<p>(The single quotes and no-longer-necessary attributes are from WP, would like to fix that... maybe next update...)</p>';
			echo '<p><strong>Note: If you do <em>not</em> include Modernizr, the IEShiv JS <em>will</em> be added to accommodate the HTML5 elements used in Boilerplate in weaker browsers.</strong></p>';
		}

	//	callback fn for jquery_js
		function jquery_js_setting() {
			$options = get_option('plugin_options');
			$checked = (isset($options['jquery_js']) && $options['jquery_js']) ? 'checked="checked" ' : '';
			echo '<input class="check-field" type="checkbox" name="plugin_options[jquery_js]" value="true" ' .$checked. '/>';
			echo '<p><a href="http://jquery.com/">jQuery</a> is a JS library that aids greatly in developing high-quality JavaScript quickly and efficiently.</p>';
			echo '<p>Selecting this option will add the following code to your pages just before the &lt;/body&gt; (note the lack of a version, when you\'re ready to upgrade, simply copy/paste the new version into the file below, and your site is ready to go!):<br />';
			echo '<code>&lt;script type=\'text/javascript\' src=\'http://ajax.googleapis.com/ajax/libs/jquery/1.6.0/jquery.min.js\'&gt;&lt;/script&gt;</code></p>';
			echo '<p>(The single quotes and no-longer-necessary attributes are from WP, would like to fix that... maybe next update...)</p>';
		}

	//	callback fn for plugins_js
		function plugins_js_setting() {
			$options = get_option('plugin_options');
			$checked = (isset($options['plugins_js']) && $options['plugins_js']) ? 'checked="checked" ' : '';
			echo '<input class="check-field" type="checkbox" name="plugin_options[plugins_js]" value="true" ' .$checked. '/>';
			echo '<p>If you choose to use any <a href="http://plugins.jquery.com/">jQuery plug-ins</a>, I recommend downloading and concatenating them together in a single JS file, as below.  This will <a href="http://developer.yahoo.com/performance/rules.html">reduce your site\'s HTTP Requests</a>, making your site a better experience.</p>';
			echo '<p>Selecting this option will add the following code to your pages just before the <code>&lt;/body&gt;</code>:</p>';
			echo '<code>&lt;script type=\'text/javascript\' src=\''.get_template_directory_uri().'js/plug-in.js?ver=x\'&gt;&lt;/script&gt;</code>';
			echo '<p>(The single quotes and no-longer-necessary attributes are from WP, would like to fix that... maybe next update...)</p>';
			echo '<p><strong>Note: If you do <em>not</em> include jQuery, this file will <em>not</em> be added to the page.</strong></p>';
		}

	//	callback fn for site_js
		function site_js_setting() {
			$options = get_option('plugin_options');
			$checked = (isset($options['site_js']) && $options['site_js']) ? 'checked="checked" ' : '';
			echo '<input class="check-field" type="checkbox" name="plugin_options[site_js]" value="true" ' .$checked. '/>';
			echo '<p>If you would like to add your own site JavaScript file, Boilerplate provides a starter file located in:</p>';
			echo '<code>'.get_template_directory_uri(). 'js/script.js</code>';
			echo '<p>Add what you want to that file and select this option.</p>';
			echo '<p>Selecting this option will add the following code to your pages just before the <code>&lt;/body&gt;</code>:</p>';
			echo '<code>&lt;script type=\'text/javascript\' src=\''.get_template_directory_uri().'js/script.js\'&gt;&lt;/script&gt;</code>';
			echo '<p>(The single quotes and no-longer-necessary attributes are from WP, would like to fix that... maybe next update...)</p>';
		}

	//	callback fn for belated_png_js
		function belated_png_js_setting() {
			$options = get_option('plugin_options');
			$checked = (isset($options['belated_png_js']) && $options['belated_png_js']) ? 'checked="checked" ' : '';
			echo '<input class="check-field" type="checkbox" name="plugin_options[belated_png_js]" value="true" ' .$checked. '/>';
			echo '<p><a href="http://www.dillerdesign.com/experiment/DD_belatedPNG/">DD_belatedPNG</a> adds IE6 support for PNG images used as CSS background images and HTML &lt;img/&gt;</p>';
			echo '<p>Selecting this option will add the following code to your pages just before the <code>&lt;/body&gt;</code>:</p>';
			echo '<code>&lt;!--[if lt IE 7]&gt;</code>';
			echo '<code>&lt;script type=\'text/javascript\' src=\''.get_template_directory_uri().'js/dd_belatedpng.js?ver=x\'&gt;&lt;/script&gt;</code>';
			echo '<code>&lt;script&gt;DD_belatedPNG.fix(\'img, .png_bg\');&lt;/script&gt;</code>';
			echo '<code>&lt;![endif]--&gt;</code>';
		}

	//	callback fn for google_analytics_js
		function google_analytics_js_setting() {
			$options = get_option('plugin_options');
			$checked = (isset($options['google_analytics_js']) && $options['google_analytics_js']) ? 'checked="checked" ' : '';
			$account = (isset($options['google_analytics_account']) && $options['google_analytics_account']) ? $options['google_analytics_account'] : 'XXXXX-X';
			echo '<input class="check-field" type="checkbox" name="plugin_options[google_analytics_js]" value="true" ' .$checked. '/>';
			echo '<p>To include Google Analytics, select this option and include your account number here:<br />';
			echo 'UA-<input type="text" size="10" name="plugin_options[google_analytics_account]" value="'.$account.'" onfocus="javascript:if(this.value===\'XXXXX-X\'){this.select();}" /></p>';
			echo '<p>Selecting this option will add the following code to your pages just before the <code>&lt;/body&gt;</code>, where \'UA-XXXXX-X\' will be replaced with the code you insert above:</p>';
			echo '<code>&lt;script&gt;</code>';
			echo '<code>var _gaq=[["_setAccount","'.(($account !== 'XXXXX-X') ? 'UA-'.$account : 'UA-XXXXX-X').'"],["_trackPageview"]];</code>';
			echo '<code>(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];g.async=1;</code>';
			echo '<code>g.src=("https:"==location.protocol?"//ssl":"//www")+".google-analytics.com/ga.js";</code>';
			echo '<code>s.parentNode.insertBefore(g,s)}(document,"script"));</code>';
			echo '<code>&lt;/script&gt;</code>';
			echo '<p><strong>Note: You must check the box <em>and</em> provide a UA code for this to be added to your pages.</strong></p>';
		}
		

/*	4)	Create functions to add above elements to pages */

	//	$options['chrome']
		function add_chrome() {
			echo '<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />'.PHP_EOL;
		}

	//	$options['viewport']
		function add_viewport() {
			echo '<meta name="viewport" content="width=device-width, initial-scale=1.0" />'.PHP_EOL;
		}

	//	$options['favicon']
		function add_favicon() {
			echo '<link rel="shortcut icon" href="/favicon.ico" />'.PHP_EOL;
		}

	//	$options['favicon_ithing']
		function add_favicon_ithing() {
			echo '<link rel="apple-touch-icon" href="/apple-touch-icon.png" />'.PHP_EOL;
		}

	//	$options['ie_css'];
		function add_ie_stylesheet() {
			echo '<!--[if IE ]><link rel="stylesheet" href="'.get_template_directory_uri().'/css/ie.css"><![endif]-->'.PHP_EOL;
		}

	//	$options['handheld_css']
		function add_handheld_stylesheet() {
			wp_register_style( 'handheld', get_template_directory_uri() . '/css/handheld.css', array(), '', 'handheld' );
			wp_enqueue_style( 'handheld');
		}

	//	$options['print_css']; implement as: http://www.alistapart.com/articles/return-of-the-mobile-stylesheet ?
		function add_print_stylesheet() {
			wp_register_style( 'print', get_template_directory_uri() . '/css/print.css', array(), '', 'print' );
			wp_enqueue_style( 'print');
		}

	//	$options['modernizr_js']
		function add_modernizr_script() {
			wp_deregister_script( 'ieshiv' ); // get rid of IEShiv if it somehow got called too (IEShiv is included in Modernizr)
			wp_deregister_script( 'modernizr' ); // get rid of any native Modernizr
			echo '<script src="//ajax.cdnjs.com/ajax/libs/modernizr/1.7/modernizr-1.7.min.js"></script>'.PHP_EOL; // try getting from CDN
			echo '<script>!window.Modernizr && document.write(unescape(\'<script src="' .get_template_directory_uri(). 'js/libs/modernizr-1.7.min.js"></script>\'))</script>'.PHP_EOL; // fallback to local if CDN fails
		}

	//	$options['ieshiv_script']
		function add_ieshiv_script() {
			echo '<!--[if lt IE 9]>'.PHP_EOL;
			echo '	<script src="//html5shiv.googlecode.com/svn/trunk/html5.js" onload="window.ieshiv=true;"></script>'.PHP_EOL; // try getting from CDN
			echo '	<script>!window.ieshiv && document.write(unescape(\'%3Cscript src="' .get_template_directory_uri(). 'js/ieshiv.js"%3E%3C/script%3E\'))</script>'.PHP_EOL; // fallback to local if CDN fails
			echo '<![endif]-->'.PHP_EOL;
		}

	//	$options['jquery_js']
		function add_jquery_script() {
			wp_deregister_script( 'jquery' ); // get rid of WP's jQuery
			wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.6.0/jquery.min.js', array(), '' );
			wp_enqueue_script( 'jquery' );
		}

	//	$options['plugins_js']
		function add_plugin_script() {
			wp_register_script( 'plug_ins', get_template_directory_uri() . '/js/plugins.js', array('jquery'), '', true );
			wp_enqueue_script( 'plug_ins' );
		}

	//	$options['site_js']
		function add_site_script() {
			wp_register_script( 'site_script', get_template_directory_uri() . '/js/script.js', array(), '', true );
			wp_enqueue_script( 'site_script' );
		}


	//	$options['belated_png_js']
		function add_belated_png_script() {
			echo '<!--[if lt IE 7 ]>'.PHP_EOL;
			echo '<script src="' .get_template_directory_uri(). '/js/libs/dd_belatedpng.js"></script>'.PHP_EOL;
			echo '<script>DD_belatedPNG.fix(\'img, .png_bg\');</script>'.PHP_EOL;
			echo '<![endif]-->'.PHP_EOL;
		}

	//	$options['google_analytics_js']
		function add_google_analytics_script() {
			$options = get_option('plugin_options');
			$account = $options['google_analytics_account'];
			echo PHP_EOL.'<script>'.PHP_EOL;
			echo 'var _gaq=[["_setAccount","UA-'.$account.'"],["_trackPageview"]];'.PHP_EOL;
			echo '(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];g.async=1;'.PHP_EOL;
			echo 'g.src=("https:"==location.protocol?"//ssl":"//www")+".google-analytics.com/ga.js";'.PHP_EOL;
			echo 's.parentNode.insertBefore(g,s)}(document,"script"));'.PHP_EOL;
			echo '</script>'.PHP_EOL;
		}


/*	5)	Add Boilerplate options to page as requested */
		if (!is_admin() ) {
			$options = get_option('plugin_options');
			if (isset($options['chrome']) && $options['chrome']) {
				add_action('wp_print_styles', 'add_chrome');
			}
			if (isset($options['viewport']) && $options['viewport']) {
				add_action('wp_print_styles', 'add_viewport');
			}
			if (isset($options['favicon']) && $options['favicon']) {
				add_action('wp_print_styles', 'add_favicon');
			}
			if (isset($options['favicon_ithing']) && $options['favicon_ithing']) {
				add_action('wp_print_styles', 'add_favicon_ithing');
			}
			if (isset($options['modernizr_js']) && $options['modernizr_js']) {
				add_action('wp_print_styles', 'add_modernizr_script');
			} else { // if Modernizr isn't selected, add IEShiv inside an IE Conditional Comment
				add_action('wp_print_styles', 'add_ieshiv_script');
			}
			if (isset($options['ie_css']) && $options['ie_css']) {
				add_action('wp_print_styles', 'add_ie_stylesheet');
			}
			if (isset($options['handheld_css']) && $options['handheld_css']) {
				add_action('wp_print_styles', 'add_handheld_stylesheet');
			}
			if (isset($options['print_css']) && $options['print_css']) {
				add_action('wp_print_styles', 'add_print_stylesheet');
			}
			if (isset($options['jquery_js']) && $options['jquery_js']) {
				add_action('wp_loaded', 'add_jquery_script');
			}
			// for jQuery plug-ins, make sure jQuery was also set
			if (isset($options['jquery_js']) && $options['jquery_js'] && isset($options['plugins_js']) && $options['plugins_js']) {
				add_action('wp_footer', 'add_plugin_script');
			}
			if (isset($options['site_js']) && $options['site_js']) {
				add_action('wp_footer', 'add_site_script');
			}
			if (isset($options['belated_png_js']) && $options['belated_png_js']) {
				add_action('wp_footer', 'add_belated_png_script');
			}
			if (isset($options['google_analytics_js']) && $options['google_analytics_js']) {
				add_action('wp_footer', 'add_google_analytics_script');
			}
		}

/*	End customization for Boilerplate */

?>