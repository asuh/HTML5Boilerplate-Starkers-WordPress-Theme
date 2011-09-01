<?php

/*
	Begin Boilerplate Admin panel.

	There are essentially 5 sections to this:
	1)	Add "Boilerplate Admin" link to left-nav Admin Menu & callback function for clicking tat menu link
	2)	Add Admin Page CSS if on the Admin Page
	3)	Add "Boilerplate Admin" Page options
	4)	Create functions to add above elements to pages
	5)	Add Boilerplate options to page as requested
*/

/*	1)	Add "Boilerplate Admin" link to left-nav Admin Menu */

	//	Add option if in Admin Page
		function create_boilerplate_admin_page() {
		//	add_theme_page( $page_title, $menu_title, $capability, $menu_slug, $function);
			add_theme_page('Boilerplate Admin', 'Boilerplate Admin', 'administrator', 'boilerplate-admin', 'build_boilerplate_admin_page');
		}
		add_action('admin_menu', 'create_boilerplate_admin_page');

	//	You get this if you click the left-column "Boilerplate Admin" (added above)
		function build_boilerplate_admin_page() {
		?>
			<div id="boilerplate-options-wrap">
				<div class="icon32" id="icon-tools"><br /></div>
				<h2>Boilerplate Admin</h2>
				<p>So, there's actually a tremendous amount going on here.  If you're not familiar with <a href="http://html5boilerplate.com/">HTML5 Boilerplate</a> or the <a href="http://wordpress.org/extend/themes/twentyeleven">Twenty Eleven theme</a> (upon which this theme is based) you should check them out.</p>
				<p>Choose below which options you want included in your site.</p>
				<p>The clumsiest part of this plug-in is dealing with the CSS files.  Check the <a href="<?php echo get_template_directory_uri() ?>/readme.txt">Read Me file</a> for details on how I suggest handling them.</p>
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
			echo '<link rel="stylesheet" href="' .get_template_directory_uri(). '/boilerplate-admin/admin-style.css" />'.PHP_EOL;
		}
		add_action('admin_head', 'admin_register_head');

/*	3)	Add "Boilerplate Admin" Page options */

	//	Register form elements
		function register_and_build_fields() { 
			register_setting('plugin_options', 'plugin_options', 'validate_setting');
			add_settings_section('main_section', '', 'section_cb', 'boilerplate-admin');
			add_settings_field('toolbar', 'IE6 Image Toolbar?:', 'toolbar_setting', 'boilerplate-admin', 'main_section');
			add_settings_field('google_chrome', 'IE-edge / Google Chrome?:', 'google_chrome_setting', 'boilerplate-admin', 'main_section');
			add_settings_field('viewport', '<em><abbr title="iPhone, iTouch, iPad...">iThings</abbr></em> use full zoom?:', 'viewport_setting', 'boilerplate-admin', 'main_section');
			add_settings_field('favicon', 'Got Favicon?:', 'favicon_setting', 'boilerplate-admin', 'main_section');
			add_settings_field('favicon_ithing', 'Got <em><abbr title="iPhone, iTouch, iPad...">iThing</abbr></em> Favicon?', 'favicon_ithing_setting', 'boilerplate-admin', 'main_section');
			add_settings_field('modernizr_js', 'Modernizr JS?:', 'modernizr_js_setting', 'boilerplate-admin', 'main_section');
			add_settings_field('respond_js', 'Respond JS?:', 'respond_js_setting', 'boilerplate-admin', 'main_section');
			add_settings_field('jquery_js', 'jQuery JS?:', 'jquery_js_setting', 'boilerplate-admin', 'main_section');
			add_settings_field('plugins_js', 'jQuery Plug-ins JS?:', 'plugins_js_setting', 'boilerplate-admin', 'main_section');
			add_settings_field('site_js', 'Site-specific JS?:', 'site_js_setting', 'boilerplate-admin', 'main_section');
			add_settings_field('belated_png_js', 'Belated PNG JS?:', 'belated_png_js_setting', 'boilerplate-admin', 'main_section');
			add_settings_field('chrome_frame', 'Chrome-Frame?:', 'chrome_frame_setting', 'boilerplate-admin', 'main_section');
			add_settings_field('google_analytics_js', 'Google Analytics?:', 'google_analytics_js_setting', 'boilerplate-admin', 'main_section');
			add_settings_field('cache_buster', 'Cache-Buster?:', 'cache_buster_setting', 'boilerplate-admin', 'main_section');
			add_settings_field('footer_credit', 'Footer Credit?:', 'footer_credit_setting', 'boilerplate-admin', 'main_section');
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
	
	//	callback fn for toolbar
		function toolbar_setting() {
			$options = get_option('plugin_options');
			$checked = (isset($options['toolbar']) && $options['toolbar']) ? 'checked="checked" ' : '';
			echo '<input class="check-field" type="checkbox" name="plugin_options[toolbar]" value="true" ' .$checked. '/>';
			echo '<p>Kill the IE6 Image Toolbar that appears when users hover over images on your site.</p>';
			echo '<p>Selecting this option will add the following code to the <code class="html">&lt;head&gt;</code> of your pages:</p>';
			echo '<code>&lt;meta http-equiv=<span>"imagetoolbar"</span> content=<span>"false"</span> /&gt;</code>';
		}

	//	callback fn for google_chrome
		function google_chrome_setting() {
			$options = get_option('plugin_options');
			$checked = (isset($options['google_chrome']) && $options['google_chrome']) ? 'checked="checked" ' : '';
			echo '<input class="check-field" type="checkbox" name="plugin_options[google_chrome]" value="true" ' .$checked. '/>';
			echo '<p>Force the most-recent IE rendering engine or users with <a href="http://www.chromium.org/developers/how-tos/chrome-frame-getting-started">Google Chrome Frame</a> installed to see your site using Google Frame.</p>';
			echo '<p>Selecting this option will add the following code to the <code class="html">&lt;head&gt;</code> of your pages:</p>';
			echo '<code>&lt;meta http-equiv=<span>"X-UA-Compatible"</span> content=<span>"IE=edge,chrome=1"</span> /&gt;</code>';
		}

	//	callback fn for viewport
		function viewport_setting() {
			$options = get_option('plugin_options');
			$checked = (isset($options['viewport']) && $options['viewport']) ? 'checked="checked" ' : '';
			echo '<input class="check-field" type="checkbox" name="plugin_options[viewport]" value="true" ' .$checked. '/>';
			echo '<p>Force <em><abbr title="iPhone, iTouch, iPad...">iThings</abbr></em> to <a href="http://developer.apple.com/library/safari/#documentation/AppleApplications/Reference/SafariWebContent/UsingtheViewport/UsingtheViewport.html#//apple_ref/doc/uid/TP40006509-SW19">show site at full-zoom</a>, instead of trying to show the entire page.</p>';
			echo '<p>Selecting this option will add the following code to the <code class="html">&lt;head&gt;</code> of your pages:</p>';
			echo '<code>&lt;meta name=<span>"viewport"</span> content=<span>"width=device-width;initial-scale=1.0;"</span> /&gt;</code>';
		}

	//	callback fn for favicon
		function favicon_setting() {
			$options = get_option('plugin_options');
			$checked = (isset($options['favicon']) && $options['favicon']) ? 'checked="checked" ' : '';
			echo '<input class="check-field" type="checkbox" name="plugin_options[favicon]" value="true" ' .$checked. '/>';
			echo '<p>If you plan to use a <a href="http://en.wikipedia.org/wiki/Favicon">favicon</a> for your site, place the "favicon.ico" file in the root directory of your site.</p>';
			echo '<p>If the file is in the right location, you don\'t really need to select this option, browsers will automatically look there and no additional code will be added to your pages.</p>';
			echo '<p>Selecting this option will add the following code to the <code class="html">&lt;head&gt;</code> of your pages:</p>';
			echo '<code>&lt;link rel=<span>"shortcut icon"</span> href=<span>"/favicon.ico"</span> /&gt;</code>';
		}

	//	callback fn for favicon_ithing
		function favicon_ithing_setting() {
			$options = get_option('plugin_options');
			$checked = (isset($options['favicon_ithing']) && $options['favicon_ithing']) ? 'checked="checked" ' : '';
			echo '<input class="check-field" type="checkbox" name="plugin_options[favicon_ithing]" value="true" ' .$checked. '/>';
			echo '<p>To allow <em><abbr title="iPhone, iTouch, iPad...">iThing</abbr></em> users to <a href="http://developer.apple.com/library/safari/#documentation/AppleApplications/Reference/SafariWebContent/ConfiguringWebApplications/ConfiguringWebApplications.html">add an icon for your site to their Home screen</a>, place the "apple-touch-icon.png" file in the root directory of your site.</p>';
			echo '<p>If the file is in the right location, you don\'t really need to select this option, browsers will automatically look there and no additional code will be added to your pages.</p>';
			echo '<p>Selecting this option will add the following code to the <code class="html">&lt;head&gt;</code> of your pages:</p>';
			echo '<code>&lt;link rel=<span>"apple-touch-icon"</span> href=<span>"/apple-touch-icon.png"</span> /&gt;</code>';
			echo '<code>&lt;link rel=<span>"apple-touch-icon"</span> sizes=<span>"72x72"</span> href=<span>"/apple-touch-icon-ipad.png" /&gt;</code>';
			echo '<code>&lt;link rel=<span>"apple-touch-icon"</span> sizes=<span>"114x114"</span> href=<span>"/apple-touch-icon-iphone4.png"</span> /&gt;</code>';
		}

	//	callback fn for modernizr_js
		function modernizr_js_setting() {
			$options = get_option('plugin_options');
			$checked = (isset($options['modernizr_js']) && $options['modernizr_js']) ? 'checked="checked" ' : '';
			echo '<input class="check-field" type="checkbox" name="plugin_options[modernizr_js]" value="true" ' .$checked. '/>';
			echo '<p><a href="http://modernizr.com/">Modernizr</a> is a JS library that appends classes to the <code class="html">&lt;html&gt;</code> that indicate whether the user\'s browser is capable of handling advanced CSS, like "cssreflections" or "no-cssreflections".  It\'s a really handy way to apply varying CSS techniques, depending on the user\'s browser\'s abilities, without resorting to CSS hacks.</p>';
			echo '<p>Selecting this option will add the following code to the <code class="html">&lt;head&gt;</code> of your pages (note the lack of a version, when you\'re ready to upgrade, simply copy/paste the new version into the file below, and your site is ready to go!):</p>';
			//dropping cdnjs per Paul & Divya recommendation, leaving below line as it will hopefully soon become a Google CDN link
			echo '<code><b>&lt;</b>script src<b>=</b><span>"//cdnjs.cloudflare.com/ajax/libs/modernizr/2.0.6/modernizr.min.js"</span><b>&gt;&lt;/</b>script<b>&gt;</b></code>';
			//echo '<code>&lt;script&gt;!window.Modernizr && document.write(unescape(\'&lt;script src="' .get_template_directory_uri(). '/js/libs/modernizr-2.0.min.js"><\/script>\'))&lt;/script&gt;</code>';
			//echo '<code>&lt;script type=\'text/javascript\' src=\'' .get_template_directory_uri().'/js/libs/modernizr-2.0.min.js\'&gt;&lt;/script&gt;</code>';
			echo '<p><strong>Note: If you do <em>not</em> include Modernizr, the IEShiv JS <em>will</em> be added to accommodate the HTML5 elements used in Boilerplate in weaker browsers:</strong></p>';
			echo '<code class="comment">&lt;!--[if lt IE 9]&gt;</code>';
			echo '<code class="comment">	&lt;script src="//html5shiv.googlecode.com/svn/trunk/html5.js" onload="window.ieshiv=true;"&gt;&lt;/script&gt;</code>';
			echo '<code class="comment">	&lt;script&gt;!window.ieshiv && document.write(unescape(\'&lt;script src="' .get_template_directory_uri(). '/js/ieshiv.js"&gt;&lt;/script&gt;\'))&lt;/script&gt;</code>';
			echo '<code class="comment">&lt;![endif]--&gt;</code>';
		}

	//	callback fn for respond_js
		function respond_js_setting() {
			$options = get_option('plugin_options');
			$checked = (isset($options['respond_js']) && $options['respond_js']) ? 'checked="checked" ' : '';
			echo '<input class="check-field" type="checkbox" name="plugin_options[respond_js]" value="true" ' .$checked. '/>';
			echo '<p><a href="http://filamentgroup.com/lab/respondjs_fast_css3_media_queries_for_internet_explorer_6_8_and_more/">Respond.js</a> is a JS library that helps IE<=8 understand <code>@media</code> queries, specifically <code>min-width</code> and <code>max-width</code>, allowing you to more reliably implement <a href="http://www.alistapart.com/articles/responsive-web-design/">responsive design</a> across all browsers.</p>';
			echo '<p>Selecting this option will add the following code to the <code class="html">&lt;head&gt;</code> of your pages (note the lack of a version, when you\'re ready to upgrade, simply copy/paste the new version into the file below, and your site is ready to go!):</p>';
			echo '<code><b>&lt;</b>script type<b>=</b><span>\'text/javascript\'</span> src=<span>"' .get_template_directory_uri().'/js/libs/respond.min.js"</span><b>&gt;&lt;/</b>script<b>&gt;</b></code>';
		}

	//	callback fn for jquery_js
		function jquery_js_setting() {
			$options = get_option('plugin_options');
			$checked = (isset($options['jquery_js']) && $options['jquery_js']) ? 'checked="checked" ' : '';
			echo '<input class="check-field" type="checkbox" name="plugin_options[jquery_js]" value="true" ' .$checked. '/>';
			echo '<p><a href="http://jquery.com/">jQuery</a> is a JS library that aids greatly in developing high-quality JavaScript quickly and efficiently.</p>';
			echo '<p>Selecting this option will add the following code to your pages just before the <code class="html">&lt;/head&gt;</code></p>';
			echo '<code><b>&lt;</b>script src<b>=</b><span>\'http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js\'</span><b>&gt;&lt;/</b>script<b>&gt;</b></code>';
			echo '<p>The above code first tries to download jQuery from Google\'s CDN (which might be available via the user\'s browser cache).</p>';
		}

	//	callback fn for plugins_js
		function plugins_js_setting() {
			$options = get_option('plugin_options');
			$checked = (isset($options['plugins_js']) && $options['plugins_js']) ? 'checked="checked" ' : '';
			echo '<input class="check-field" type="checkbox" name="plugin_options[plugins_js]" value="true" ' .$checked. '/>';
			echo '<p>If you choose to use any <a href="http://plugins.jquery.com/">jQuery plug-ins</a>, I recommend downloading and concatenating them together in a single JS file, as below.  This will <a href="http://developer.yahoo.com/performance/rules.html">reduce your site\'s HTTP Requests</a>, making your site a better experience.</p>';
			echo '<p>Selecting this option will add the following code to your pages just before the <code class="html">&lt;/body&gt;</code>:</p>';
			echo '<code><b>&lt;</b>script type<b>=</b><span>\'text/javascript\'</span> src=<span>\'' .get_stylesheet_directory_uri().'/js/plug-in.js\'</span><b>&gt;&lt;/</b>script<b>&gt;</b></code>';
			echo '<p>(The single quotes and no-longer-necessary attributes are from WP, would like to fix that... maybe next update...)</p>';
			echo '<p><strong>Note: If you do <em>not</em> include jQuery, this file will <em>not</em> be added to the page.</strong></p>';
		}

	//	callback fn for site_js
		function site_js_setting() {
			$options = get_option('plugin_options');
			$checked = (isset($options['site_js']) && $options['site_js']) ? 'checked="checked" ' : '';
			echo '<input class="check-field" type="checkbox" name="plugin_options[site_js]" value="true" ' .$checked. '/>';
			echo '<p>If you would like to add your own site JavaScript file, Boilerplate provides a starter file located in:</p>';
			echo '<code><span>' .get_stylesheet_directory_uri(). '/js/script.js</span></code>';
			echo '<p>Add what you want to that file and select this option.</p>';
			echo '<p>Selecting this option will add the following code to your pages just before the <code class="html">&lt;/body&gt;</code>:</p>';
			echo '<code><b>&lt;</b>script type<b>=</b><span>\'text/javascript\'</span> src=<span>\'' .get_stylesheet_directory_uri().'/js/script.js\'</span><b>&gt;&lt;/</b>script<b>&gt;</b></code>';
			echo '<p>(The single quotes and no-longer-necessary attributes are from WP, would like to fix that... maybe next update...)</p>';
		}

	//	callback fn for belated_png_js
		function belated_png_js_setting() {
			$options = get_option('plugin_options');
			$checked = (isset($options['belated_png_js']) && $options['belated_png_js']) ? 'checked="checked" ' : '';
			echo '<input class="check-field" type="checkbox" name="plugin_options[belated_png_js]" value="true" ' .$checked. '/>';
			echo '<p><a href="http://www.dillerdesign.com/experiment/DD_belatedPNG/">DD_belatedPNG</a> adds IE6 support for PNG images used as CSS background images and HTML &lt;img/&gt;</p>';
			echo '<p>Selecting this option will add the following code to your pages just before the <code class="html">&lt;/body&gt;</code>:</p>';
			echo '<code class="comment">&lt;!--[if lt IE 7]&gt;</code>';
			echo '<code class="comment">&lt;script type=\'text/javascript\' src=\'' .get_template_directory_uri().'/js/libs/dd_belatedpng.js\'&gt;&lt;/script&gt;</code>';
			echo '<code class="comment">&lt;script&gt;DD_belatedPNG.fix(\'img, .png_bg\');&lt;/script&gt;</code>';
			echo '<code class="comment">&lt;![endif]--&gt;</code>';
		}

	//	callback fn for chrome_frame
		function chrome_frame_setting() {
			$options = get_option('plugin_options');
			$checked = (isset($options['chrome_frame']) && $options['chrome_frame']) ? 'checked="checked" ' : '';
			echo '<input class="check-field" type="checkbox" name="plugin_options[chrome_frame]" value="true" ' .$checked. '/>';
			echo '<p>Prompt IE 6 users to install <a href="http://chromium.org/developers/how-tos/chrome-frame-getting-started">Chrome Frame</a>.</p>';
			echo '<p>Selecting this option will add the following code just before the <code class="html">&lt;/body&gt;</code>:</p>';
			echo '<code class="comment">&lt;!--[if lt IE 7]&gt;</code>';
			echo '<code class="comment">&lt;script defer src=\'http://ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js\'&gt;&lt;/script&gt;</code>';
			echo '<code class="comment">&lt;script defer&gt;window.attachEvent("onload",function(){CFInstall.check({mode:"overlay"})})&lt;/script&gt;</code>';
			echo '<code class="comment">&lt;![endif]--&gt;</code>';
		}
		
	//	callback fn for google_analytics_js
		function google_analytics_js_setting() {
			$options = get_option('plugin_options');
			$checked = (isset($options['google_analytics_js']) && $options['google_analytics_js'] && isset($options['google_analytics_account']) && $options['google_analytics_account'] && $options['google_analytics_account'] !== 'XXXXX-X') ? 'checked="checked" ' : '';
			$account = (isset($options['google_analytics_account']) && $options['google_analytics_account']) ? str_replace('UA-','',$options['google_analytics_account']) : 'XXXXX-X';
			$msg = ($account === 'XXXXX-X') ? ', where </code>XXXXX-X</code> will be replaced with the code you insert above' : '';
			echo '<input class="check-field" type="checkbox" name="plugin_options[google_analytics_js]" value="true" ' .$checked. '/>';
			echo '<p>To include Google Analytics, select this option and include your account number here:<br />';
			echo 'UA-<input type="text" size="6" name="plugin_options[google_analytics_account]" value="'.$account.'" onfocus="javascript:if(this.value===\'XXXXX-X\'){this.select();}" /></p>';
			echo '<p>Selecting this option will add the following code to your pages just before the <code class="html">&lt;/body&gt;</code>'.$msg.':</p>';
			echo '<code><b>&lt;</b>script<b>&gt;</b></code>';
			echo '<code>var <b>_gaq</b>=<b>[[</b><span>"_setAccount"</span><b>,</b><span>"UA-'.(($account !== 'XXXXX-X') ? $account : 'XXXXX-X').'"</span><b>],[</b><span>"_trackPageview"</span><b>],[</b><span>"_trackPageLoadTime"</span><b>]]</b>;</code>';
			echo '<code><b>(</b>function<b>(d,t){</b>var <b>g</b>=<b>d</b>.createElement<b>(t),s</b>=<b>d</b>.getElementsByTagName<b>(t)[</b>0<b>];</code>';
			echo '<code><b>g</b>.src=<b>(</b><span>"https:"</span>==<b>location</b>.protocol<b>?</b><span>"//ssl"</span><b>:</b><span>"//www"</span><b>)</b>+<span>".google-analytics.com/ga.js"</span><b>;</b></code>';
			echo '<code><b>s</b>.parentNode.insertBefore<b>(g,s)}(</b>document<b>,</b><span>"script"</span><b>));</b></code>';
			echo '<code><b>&lt;</b>/script<b>&gt;</b></code>';
			echo '<p><strong>Note: You must check the box <em>and</em> provide a UA code for this to be added to your pages.</strong></p>';
		}
		
	//	callback fn for cache_buster
		function cache_buster_setting() {
			$options = get_option('plugin_options');
			$checked = (isset($options['cache_buster']) && $options['cache_buster']) ? 'checked="checked" ' : '';
			$version = (isset($options['cache_buster_version']) && $options['cache_buster_version']) ? $options['cache_buster_version'] : '1';
			echo '<input class="check-field" type="checkbox" name="plugin_options[cache_buster]" value="true" ' .$checked. '/>';
			echo '<p>To force browsers to fetch a new version of a file, versus one it might already have cached, you can add a "cache buster" to the end of your CSS and JS files.  ';
			echo 'To increment the cache buster version number, type something here:<br />';
			echo '<input type="text" size="4" name="plugin_options[cache_buster_version]" value="'.$version.'" /></p>';
			echo '<p>Selecting this option will add the following code to the end of all of your CSS and JS file names on all of your pages:</p>';
			echo '<code>?ver='.$version.'</code>';
		}

	//	callback for footer credit
		function footer_credit_setting() {
			$options = get_option('plugin_options');
			$checked = (isset($options['footer_credit']) && $options['footer_credit']) ? 'checked="checked" ' : '';
			$business_name = (isset($options['your_business_name']) && $options['your_business_name']) ? $options['your_business_name'] : 'Your Business Name';
			$business_title = (isset($options['your_business_title']) && $options['your_business_title']) ? $options['your_business_title'] : 'Your Business Title';
			$website = (isset($options['your_business_website']) && $options['your_business_website']) ? $options['your_business_website'] : 'yourbusiness.com';
			$credit = (isset($options['your_business_credit']) && $options['your_business_credit']) ? $options['your_business_credit'] : 'maintained';
			echo '<input class="check-field" type="checkbox" name="plugin_options[footer_credit]" value="true" ' .$checked. '/>';
			echo '<p>If you are developing a website for a client and want a linkback to your site in the footer, here\'s an easy way to give your business site credit. <strong>All fields are required</strong>.</p>';
			echo '<p><label for="business_name">Your Business Name: </label><input type="text" size="40" id="business_name" name="plugin_options[your_business_name]" value="'.$business_name.'" onfocus="javascript:if(this.value===\'Your Business Name\'){this.select();}" /></p>';
			echo '<p><label for="business_title">Your Business Title: </label><input type="text" size="40" id="business_title" name="plugin_options[your_business_title]" value="'.$business_title.'" onfocus="javascript:if(this.value===\'Your Business Title\'){this.select();}" /></p>';
			echo '<p><label for="business_website">Your Business URI: </label><input type="text" size="40" id="business_website" name="plugin_options[your_business_website]" value="'.$website.'" onfocus="javascript:if(this.value===\'yourbusiness.com\'){this.select();}" /></p>';
			echo '<p><label for="business_credit">Your Business Credit: </label><input type="text" size="40" id="business_credit" name="plugin_options[your_business_credit]" value="'.$credit.'" onfocus="javascript:if(this.value===\'Your Business Credit\'){this.select();}" /></p>';
			echo '<p>The code will look like this:</p>';
			echo '<code><em>Site Title</em> is '.$credit.' by &lt;a href=<span>"'.(($website !== 'yourbusiness.com') ? 'http://'.$website : 'http://yourbusiness.com').'"</span> title=<span>"'.(($business_title !== 'Your Business Title') ? $business_title : 'Your Business Title').'"</span>&gt;'.(($business_name !== 'yourbusiness.com') ? $business_name : 'Your Business Name').'&lt;/a&gt;</code>';
		}

		
/*	4)	Create functions to add above elements to pages */

	//	$options['toolbar']
		function add_toolbar() {
			echo '<meta http-equiv="imagetoolbar" content="false" />'.PHP_EOL;
		}

	//	$options['google_chrome']
		function add_google_chrome() {
			echo '<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />'.PHP_EOL;
		}

	//	$options['viewport']
		function add_viewport() {
			echo '<meta name="viewport" content="width=device-width,initial-scale=1.0" />'.PHP_EOL;
		}

	//	$options['favicon']
		function add_favicon() {
			echo '<link rel="shortcut icon" href="/favicon.ico" />'.PHP_EOL;
		}

	//	$options['favicon_ithing']
		function add_favicon_ithing() {
			echo '<link rel="apple-touch-icon" href="/apple-touch-icon.png" />'.PHP_EOL;
			echo '<link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon-ipad.png" />'.PHP_EOL;
			echo '<link rel="apple-touch-icon" sizes="114x114" href="/apple-touch-icon-iphone4.png" />'.PHP_EOL;
		}

	//	$options['modernizr_js']
		function add_modernizr_script() {
			$cache = cache_buster();
			wp_deregister_script( 'ieshiv' ); // get rid of IEShiv if it somehow got called too (IEShiv is included in Modernizr)
			wp_deregister_script( 'modernizr' ); // get rid of any native Modernizr
			//dropping cdnjs per Paul & Divya recommendation, leaving below line as it will hopefully soon become a Google CDN link
			echo '<script src="//cdnjs.cloudflare.com/ajax/libs/modernizr/2.0.6/modernizr.min.js"></script>'.PHP_EOL; // try getting from CDN
			//echo '<script>!window.Modernizr && document.write(unescape(\'<script src="' .get_template_directory_uri(). '/js/libs/modernizr-2.0.min.js'.$cache.'"><\/script>\'))</script>'.PHP_EOL; // fallback to local if CDN fails
			//echo '<script src="' .get_template_directory_uri(). '/js/libs/modernizr-2.0.min.js'.$cache.'"></script>'.PHP_EOL;
		}

	//	$options['ieshiv_script']
		function add_ieshiv_script() {
			$cache = cache_buster();
			echo '<!--[if lt IE 9]>'.PHP_EOL;
			echo '	<script src="//html5shiv.googlecode.com/svn/trunk/html5.js" onload="window.ieshiv=true;"></script>'.PHP_EOL; // try getting from CDN
			echo '<script>!window.ieshiv && document.write(unescape(\'<script src="' .get_template_directory_uri(). '/js/ieshiv.js'.$cache.'"><\/script>\'))</script>'.PHP_EOL; // fallback to local if CDN fails
			echo '<![endif]-->'.PHP_EOL;
		}

	//	$options['respond_js']
		function add_respond_script() {
			$cache = cache_buster();
			wp_register_script( 'respond', get_template_directory_uri() . '/js/libs/respond.min.js', array(), str_replace('?ver=','',$cache) );
			wp_enqueue_script( 'respond' );
		}

	//	$options['jquery_js']
		function add_jquery_script() {
			$cache = cache_buster();
			wp_deregister_script( 'jquery' ); // get rid of WP's jQuery
			wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js', array(), str_replace('?ver=','',$cache) );
			wp_enqueue_script( 'jquery' );
		}

	//	$options['plugins_js']
		function add_plugin_script() {
			$cache = cache_buster();
			wp_register_script( 'plug_ins', get_stylesheet_directory_uri() . '/js/plugins.js', array('jquery'), str_replace('?ver=','',$cache), true );
			wp_enqueue_script( 'plug_ins' );
		}

	//	$options['site_js']
		function add_site_script() {
			$cache = cache_buster();
			wp_register_script( 'site_script', get_stylesheet_directory_uri() . '/js/script.js', array(), str_replace('?ver=','',$cache), true );
			wp_enqueue_script( 'site_script' );
		}

	//	$options['belated_png_js']
		function add_belated_png_script() {
			echo '<!--[if lt IE 7 ]>'.PHP_EOL;
			echo '<script src="' .get_template_directory_uri(). '/js/libs/dd_belatedpng.js"></script>'.PHP_EOL;
			echo '<script>DD_belatedPNG.fix(\'img, .png_bg\');</script>'.PHP_EOL;
			echo '<![endif]-->'.PHP_EOL;
		}

	//	$options['chrome_frame']
		function add_chrome_frame() {
			echo '<!--[if lt IE 7 ]>'.PHP_EOL;
			echo '<script defer src="http://ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>'.PHP_EOL;
			echo '<script defer>window.attachEvent("onload",function(){CFInstall.check({mode:"overlay"})})</script>'.PHP_EOL;
			echo '<![endif]-->'.PHP_EOL;
		}

	//	$options['google_analytics_js']
		function add_google_analytics_script() {
			$options = get_option('plugin_options');
			$account = $options['google_analytics_account'];
			echo PHP_EOL.'<script>'.PHP_EOL;
			echo 'var _gaq=[["_setAccount","UA-'.str_replace('UA-','',$account).'"],["_trackPageview"],["_trackPageLoadTime"]];'.PHP_EOL;
			echo '(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];'.PHP_EOL;
			echo 'g.src=("https:"==location.protocol?"//ssl":"//www")+".google-analytics.com/ga.js";'.PHP_EOL;
			echo 's.parentNode.insertBefore(g,s)}(document,"script"));'.PHP_EOL;
			echo '</script>'.PHP_EOL;
		}

	//	$options['cache_buster']
		function cache_buster() {
			$options = get_option('plugin_options');
			return (isset($options['cache_buster']) && $options['cache_buster']) ? '?ver='.$options['cache_buster_version'] : '';
		}

	//	$options['footer_credit']
		function add_footer_credit() {
			$options = get_option('plugin_options');
			$website = $options['your_business_website'];
			$business_title = $options['your_business_title'];
			$business_name = $options['your_business_name'];
			$credit = $options['your_business_credit'];
			return bloginfo( 'name' ).' is '.$credit.' by <a href="http://'.$website.'" title="'.$business_title.'">'.$business_name.'</a>.';
		}

		
/*	5)	Add Boilerplate options to page as requested */
		if (!is_admin() ) {
			$options = get_option('plugin_options');
			if (isset($options['toolbar']) && $options['toolbar']) {
				add_action('wp_print_styles', 'add_toolbar');
			}
			if (isset($options['google_chrome']) && $options['google_chrome']) {
				add_action('wp_print_styles', 'add_google_chrome');
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
			} else { 
				// if Modernizr isn't selected, add IEShiv inside an IE Conditional Comment
				add_action('wp_print_styles', 'add_ieshiv_script');
			}
			if (isset($options['respond_js']) && $options['respond_js']) {
				add_action('wp_print_styles', 'add_respond_script');
			}
			if (isset($options['jquery_js']) && $options['jquery_js']) {
				add_action('wp_loaded', 'add_jquery_script');
			}
			// for jQuery plug-ins, make sure jQuery was also set
			if (isset($options['jquery_js']) && $options['jquery_js'] && isset($options['plugins_js']) && $options['plugins_js']) {
				add_action('wp_loaded', 'add_plugin_script');
			}
			if (isset($options['site_js']) && $options['site_js']) {
				add_action('wp_loaded', 'add_site_script');
			}
			if (isset($options['belated_png_js']) && $options['belated_png_js']) {
				add_action('wp_footer', 'add_belated_png_script');
			}
			if (isset($options['chrome_frame']) && $options['chrome_frame']) {
				add_action('wp_footer', 'add_chrome_frame');
			}
			if (isset($options['google_analytics_js']) && $options['google_analytics_js'] && isset($options['google_analytics_account']) && $options['google_analytics_account'] && $options['google_analytics_account'] !== 'XXXXX-X') {
				add_action('wp_footer', 'add_google_analytics_script');
			}
			if (isset($options['footer_credit']) && $options['footer_credit']) {
				add_shortcode('footer_credit', 'add_footer_credit');
			}
		}

/*	End customization for Boilerplate */

?>