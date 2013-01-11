<?php

/*
 	@package Boilerplate
	Theme Name: Boilerplate
	Theme URI: http://aarontgrogg.com/boilerplate/
	Description: A merger created by Aaron T. Grogg (<a href="http://aarontgrogg.com/">http://aarontgrogg.com/</a>)
		of the HTML5 Boilerplate (<a href="http://html5boilerplate.com/">http://html5boilerplate.com/</a>)
		and the Starkers theme (<a href="http://starkerstheme.com/">http://starkerstheme.com/</a>),
		Boilerplate: Starkers provides developers with an ideal, bleeding-edge, clean-start theme.
		Mark-up is minimal (thanks Elliott) and the most edge-case web technology is baked right in
		(thanks Paul, Divya and a large cast of supporting characters)!  Boilerplate themes are designed to serve as a Parent theme
		to whatever Child (<a href="http://codex.wordpress.org/Child_Themes">http://codex.wordpress.org/Child_Themes</a>) you care to add,
		but you could just as easily use this as a starting point and alter the PHP as your design needs.
		More about this theme can be found at <a href="http://aarontgrogg.com/boilerplate/">http://aarontgrogg.com/boilerplate/</a>.
	Author: Aaron T. Grogg, based on the work of Paul Irish, Divya Manian, and Elliot Jay Stocks
	Author URI: http://aarontgrogg.com/
	Version: 10.1
	Tags: custom-menu, editor-style, theme-options, threaded-comments, sticky-post, microformats, rtl-language-support, translation-ready

	License: GNU General Public License v2.0
	License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

/*	Define Boilerplate URI */
	define('H5BP_URL', get_template_directory_uri());
	define('H5BP_CHILD_URL', get_stylesheet_directory_uri());

/*
	There are essentially 5 sections to this:
	1)	Add "Boilerplate Admin" link to left-nav Admin Menu & callback function for clicking that menu link
	2)	Add Admin Page CSS if on the Admin Page
	3)	Add "Boilerplate Admin" Page options
	4)	Create functions to add above elements to pages
	5)	Add Boilerplate options to page as requested
*/


/*	Begin Boilerplate Admin panel. */

/*	1)	Add "Boilerplate Admin" link to left-nav Admin Menu & callback function for clicking that menu link */

		//	Add option if in Admin Page
		if ( ! function_exists( 'H5BP_create_boilerplate_admin_page' ) ):
			function H5BP_create_boilerplate_admin_page() {
				add_theme_page('HTML5 Boilerplate Admin', 'HTML5 Boilerplate', 'administrator', 'boilerplate-admin', 'H5BP_build_boilerplate_admin_page');
			}
		endif; // H5BP_create_boilerplate_admin_page
		add_action('admin_menu', 'H5BP_create_boilerplate_admin_page');

		//	You get this if you click the left-column "HTML5 Boilerplate Admin" (added above)
		if ( ! function_exists( 'H5BP_build_boilerplate_admin_page' ) ):
			function H5BP_build_boilerplate_admin_page() {
			?>
				<div id="boilerplate-options-wrap">
					<div class="icon32" id="icon-tools"><br /></div>
					<h2>HTML5 Boilerplate Admin</h2>
					<p>So, there's actually a tremendous amount going on here.  If you're not familiar with <a href="http://html5boilerplate.com/">HTML5 Boilerplate</a> or the <a href="http://starkerstheme.com/">Starkers theme</a> (upon which this theme is based) you should check them out.</p>
					<p>Choose below which options you want included in your site.</p>
					<form id="boilerplate-options-form" method="post" action="options.php" enctype="multipart/form-data">
						<?php settings_fields('plugin_options'); /* very last function on this page... */ ?>
						<?php do_settings_sections('boilerplate-admin'); /* let's get started! */ ?>
						<p class="submit"><input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>"></p>
					</form>
					<script>
						(function(window){
							window.H5BP = {
								form : null,
								checkboxes : null,
								checkall : function() {
									H5BP.checkboxes.attr('checked', true);
								},
								uncheckall : function() {
									H5BP.checkboxes.attr('checked', false);
								},
								init : function(){
									H5BP.form = jQuery('#boilerplate-options-form');
									H5BP.checkboxes = H5BP.form.find('input[type="checkbox"]');
									var html = '<p>'
											+ '<a href="javascript:H5BP.checkall();" title="Check all options">Check All</a> | '
											+ '<a href="javascript:H5BP.uncheckall();" title="Uncheck all options">Uncheck All</a>'
											+ '</p>';
									H5BP.form.prepend(html);
								}
							}
							H5BP.init();
						})(window);
					</script>
				</div>
			<?php
			}
		endif; // H5BP_build_boilerplate_admin_page

/*	2)	Add Admin Page CSS if on the Admin Page */

		if ( ! function_exists( 'H5BP_admin_register_head' ) ):
			function H5BP_admin_register_head() {
				echo '<link rel="stylesheet" href="' .H5BP_URL. '/boilerplate-admin/admin-style.css">'.PHP_EOL;
			}
		endif; // H5BP_admin_register_head
		add_action('admin_head', 'H5BP_admin_register_head');


/*	3)	Add "Boilerplate Admin" Page options */

		//	Register form elements
		if ( ! function_exists( 'H5BP_register_and_build_fields' ) ):
			function H5BP_register_and_build_fields() {
				register_setting('plugin_options', 'plugin_options', 'H5BP_validate_setting');
				add_settings_section('main_section', '', 'H5BP_section_cb', 'boilerplate-admin');
				add_settings_field('H5BP_google_chrome', 'IE-edge / Google Chrome?:', 'H5BP_google_chrome_setting', 'boilerplate-admin', 'main_section');
				add_settings_field('H5BP_google_verification', 'Google Verification?:', 'H5BP_google_verification_setting', 'boilerplate-admin', 'main_section');
				add_settings_field('H5BP_viewport', '<em><abbr title="iPhone, iTouch, iPad...">iThings</abbr></em> use full zoom?:', 'H5BP_viewport_setting', 'boilerplate-admin', 'main_section');
				add_settings_field('H5BP_favicon', 'Got Favicon?:', 'H5BP_favicon_setting', 'boilerplate-admin', 'main_section');
				add_settings_field('H5BP_favicon_ithing', 'Got <em><abbr title="iPhone, iTouch, iPad...">iThing</abbr></em> Favicon?', 'H5BP_favicon_ithing_setting', 'boilerplate-admin', 'main_section');
				add_settings_field('H5BP_modernizr_js', 'Modernizr JS?:', 'H5BP_modernizr_js_setting', 'boilerplate-admin', 'main_section');
				add_settings_field('H5BP_respond_js', 'Respond JS?:', 'H5BP_respond_js_setting', 'boilerplate-admin', 'main_section');
				add_settings_field('H5BP_jquery_js', 'jQuery JS?:', 'H5BP_jquery_js_setting', 'boilerplate-admin', 'main_section');
				add_settings_field('H5BP_plugins_js', 'jQuery Plug-ins JS?:', 'H5BP_plugins_js_setting', 'boilerplate-admin', 'main_section');
				add_settings_field('H5BP_site_js', 'Site-specific JS?:', 'H5BP_site_js_setting', 'boilerplate-admin', 'main_section');
				add_settings_field('H5BP_chrome_frame', 'Chrome-Frame?:', 'H5BP_chrome_frame_setting', 'boilerplate-admin', 'main_section');
				add_settings_field('H5BP_search_form', 'HTML5 Search?:', 'H5BP_search_form_setting', 'boilerplate-admin', 'main_section');
				add_settings_field('H5BP_cache_buster', 'Cache-Buster?:', 'H5BP_cache_buster_setting', 'boilerplate-admin', 'main_section');
				add_settings_field('H5BP_google_analytics_js', 'Google Analytics?:', 'H5BP_google_analytics_js_setting', 'boilerplate-admin', 'main_section');
				add_settings_field('H5BP_footer_credit', 'Footer Credit?:', 'H5BP_footer_credit_setting', 'boilerplate-admin', 'main_section');
			}
		endif; // H5BP_register_and_build_fields
		add_action('admin_init', 'H5BP_register_and_build_fields');


		//	Add Admin Page validation
		if ( ! function_exists( 'H5BP_validate_setting' ) ):
			function H5BP_validate_setting($plugin_options) {
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
		endif; // H5BP_validate_setting

		//	in case you need it...
		if ( ! function_exists( 'H5BP_section_cb' ) ):
			function H5BP_section_cb() {
				// i don't do anything here, but you could if you wanted...
			}
		endif; // H5BP_section_cb

		//	callback fn for H5BP_google_chrome
		if ( ! function_exists( 'H5BP_google_chrome_setting' ) ):
			function H5BP_google_chrome_setting() {
				$options = get_option('plugin_options');
				$checked = (isset($options['H5BP_google_chrome']) && $options['H5BP_google_chrome']) ? 'checked="checked" ' : '';
				echo '<input class="check-field" type="checkbox" name="plugin_options[H5BP_google_chrome]" value="true" ' .$checked. '/>';
				echo '<p>Force the most-recent IE rendering engine or users with <a href="http://www.chromium.org/developers/how-tos/chrome-frame-getting-started">Google Chrome Frame</a> installed to see your site using Google Frame.</p>';
				echo '<p>Selecting this option will add the following code to the <code class="html">&lt;head&gt;</code> of your pages:</p>';
				echo '<code>&lt;meta http-equiv=<span>"X-UA-Compatible"</span> content=<span>"IE=edge,chrome=1"</span>&gt;</code>';
			}
		endif; // google_chrome_setting

		//	callback fn for H5BP_google_verification
		if ( ! function_exists( 'H5BP_google_verification_setting' ) ):
			function H5BP_google_verification_setting() {
				$options = get_option('plugin_options');
				$checked = (isset($options['H5BP_google_verification']) && $options['H5BP_google_verification'] && $options['H5BP_google_verification_account'] && $options['H5BP_google_verification_account'] !== 'XXXXXXXXX...') ? 'checked="checked" ' : '';
				$account = (isset($options['H5BP_google_verification_account']) && $options['H5BP_google_verification_account']) ? $options['H5BP_google_verification_account'] : 'XXXXXXXXX...';
				$msg = ($account === 'XXXXXXXXX...') ? ', where </code>XXXXXXXXX...</code> will be replaced with the code you insert above' : '';
				echo '<input class="check-field" type="checkbox" name="plugin_options[H5BP_google_verification]" value="true" ' .$checked. '/>';
				echo '<p>Add <a href="http://www.google.com/support/webmasters/bin/answer.py?answer=35179">Google Verificaton</a> code to the <code>&lt;head&gt;</code> of all your pages.</p>';
				echo '<p>To include Google Verificaton, select this option and include your Verificaton number here:<br />';
				echo '<input type="text" size="40" name="plugin_options[H5BP_google_verification_account]" value="'.$account.'" onfocus="javascript:if(this.value===\'XXXXXXXXX...\'){this.select();}"></p>';
				echo '<p>Selecting this option will add the following code to the <code class="html">&lt;head&gt;</code> of your pages'.$msg.'</p>';
				echo '<code>&lt;meta name=<span>"google-site-verification"</span> content=<span>"'.$account.'"</soan>&gt;</code>';
			}
		endif; // H5BP_google_verification_setting

		//	callback fn for H5BP_viewport
		if ( ! function_exists( 'H5BP_viewport_setting' ) ):
			function H5BP_viewport_setting() {
				$options = get_option('plugin_options');
				$checked = (isset($options['H5BP_viewport']) && $options['H5BP_viewport']) ? 'checked="checked" ' : '';
				$setting = (isset($options['H5BP_viewport_setting']) && $options['H5BP_viewport_setting']) ? $options['H5BP_viewport_setting'] : 'width=device-width';
				echo '<input class="check-field" type="checkbox" name="plugin_options[H5BP_viewport]" value="true" ' .$checked. '/>';
				echo '<p>Force <em><abbr title="iPhone, iTouch, iPad...">iThings</abbr></em> to <a href="http://developer.apple.com/library/safari/#documentation/AppleApplications/Reference/SafariWebContent/UsingtheViewport/UsingtheViewport.html#//apple_ref/doc/uid/TP40006509-SW19">show site at full-zoom</a>, instead of trying to show the entire page.</p>';
				echo '<p>The HTML5 Boilerplate project suggests using just <code>width=device-width</code>, but you can use <a href="http://developer.apple.com/library/safari/#documentation/appleapplications/reference/safariwebcontent/usingtheviewport/usingtheviewport.html">any option you want</a>:</p>';
				echo '<p><input type="text" size="40" name="plugin_options[H5BP_viewport_setting]" value="'.$setting.'"></p>';
				echo '<p>Selecting this option will add the following code to the <code class="html">&lt;head&gt;</code> of your pages:</p>';
				echo '<code>&lt;meta name=<span>"viewport"</span> content=<span>"'.$setting.'"</span>&gt;</code>';
			}
		endif; // H5BP_viewport_setting

		//	callback fn for H5BP_favicon
		if ( ! function_exists( 'H5BP_favicon_setting' ) ):
			function H5BP_favicon_setting() {
				$options = get_option('plugin_options');
				$checked = (isset($options['H5BP_favicon']) && $options['H5BP_favicon']) ? 'checked="checked" ' : '';
				echo '<input class="check-field" type="checkbox" name="plugin_options[H5BP_favicon]" value="true" ' .$checked. '/>';
				echo '<p>If you plan to use a <a href="http://en.wikipedia.org/wiki/Favicon">favicon</a> for your site, place the "favicon.ico" file in the root directory of your site.</p>';
				echo '<p>If the file is in the right location, you don\'t really need to select this option, browsers will automatically look there and no additional code will be added to your pages.</p>';
				echo '<p>Selecting this option will add the following code to the <code class="html">&lt;head&gt;</code> of your pages:</p>';
				echo '<code>&lt;link rel=<span>"shortcut icon"</span> href=<span>"/favicon.ico"</span> /&gt;</code>';
			}
		endif; // H5BP_favicon_setting

		//	callback fn for H5BP_favicon_ithing
		if ( ! function_exists( 'H5BP_favicon_ithing_setting' ) ):
			function H5BP_favicon_ithing_setting() {
				$options = get_option('plugin_options');
				$checked = (isset($options['H5BP_favicon_ithing']) && $options['H5BP_favicon_ithing']) ? 'checked="checked" ' : '';
				echo '<input class="check-field" type="checkbox" name="plugin_options[H5BP_favicon_ithing]" value="true" ' .$checked. '/>';
				echo '<p>To allow <em><abbr title="iPhone, iTouch, iPad...">iThing</abbr></em> users to <a href="http://developer.apple.com/library/safari/#documentation/AppleApplications/Reference/SafariWebContent/ConfiguringWebApplications/ConfiguringWebApplications.html">add an icon for your site to their Home screen</a>, place the "apple-touch-icon.png" file in the root directory of your site.</p>';
				echo '<p>If the file is in the right location, you don\'t really need to select this option, browsers will automatically look there and no additional code will be added to your pages.</p>';
				echo '<p>Based upon <a href="http://mathiasbynens.be/notes/touch-icons">this Touch Icons research</a>, the icon code will be added in the specific order seen below.';
				echo '<p>Selecting this option will add the following code to the <code class="html">&lt;head&gt;</code> of your pages:</p>';
				echo '<p><strong>(Be sure to relocate all the icons to the root directory!)</strong></p>';
				echo '<code>&lt;link rel=<span>"apple-touch-icon"</span> sizes=<span>"144x144"</span> href=<span>"/apple-touch-icon-144x144-precomposed.png"</span>&gt;</code>';
				echo '<code>&lt;link rel=<span>"apple-touch-icon"</span> sizes=<span>"114x114"</span> href=<span>"/apple-touch-icon-114x114-precomposed.png"</span>&gt;</code>';
				echo '<code>&lt;link rel=<span>"apple-touch-icon"</span> sizes=<span>"72x72"</span> href=<span>"/apple-touch-icon-72x72-precomposed.png"</span>&gt;</code>';
				echo '<code>&lt;link rel=<span>"apple-touch-icon"</span> sizes=<span>"57x57"</span> href=<span>"/apple-touch-icon-57x57-precomposed.png"</span>&gt;</code>';
				echo '<code>&lt;link rel=<span>"apple-touch-icon"</span> href=<span>"/apple-touch-icon-precomposed.png"</span>&gt;</code>';
				echo '<code>&lt;link rel=<span>"apple-touch-icon"</span> href=<span>"/apple-touch-icon.png"</span>&gt;</code>';
			}
		endif; // H5BP_favicon_ithing_setting

		//	callback fn for H5BP_modernizr_js
		if ( ! function_exists( 'H5BP_modernizr_js_setting' ) ):
			function H5BP_modernizr_js_setting() {
				$options = get_option('plugin_options');
				$checked = (isset($options['H5BP_modernizr_js']) && $options['H5BP_modernizr_js']) ? 'checked="checked" ' : '';
				echo '<input class="check-field" type="checkbox" name="plugin_options[H5BP_modernizr_js]" value="true" ' .$checked. '/>';
				echo '<p><a href="http://modernizr.com/">Modernizr</a> is a JS library that appends classes to the <code class="html">&lt;html&gt;</code> that indicate whether the user\'s browser is capable of handling advanced CSS, like "cssreflections" or "no-cssreflections".  It\'s a really handy way to apply varying CSS techniques, depending on the user\'s browser\'s abilities, without resorting to CSS hacks.</p>';
				echo '<p>Selecting this option will add the following code to the <code class="html">&lt;head&gt;</code> of your pages (note the lack of a version, when you\'re ready to upgrade, simply copy/paste the new version into the file below, and your site is ready to go!):</p>';
				echo '<code><b>&lt;</b>script src=<span>"' .H5BP_URL. '/js/vendor/modernizr.js"</span><b>&gt;&lt;/</b>script<b>&gt;</b></code>';
				echo '<p><strong>Note: If you do <em>not</em> include Modernizr, the IEShiv JS <em>will</em> be added to weaker browsers to accommodate the HTML5 elements used in Boilerplate:</strong></p>';
				echo '<code class="comment">&lt;!--[if lt IE 9]&gt;</code>';
				echo '<code class="comment">&lt;script src="//html5shiv.googlecode.com/svn/trunk/html5.js" onload="window.ieshiv=true;"&gt;&lt;/script&gt;</code>';
				echo '<code class="comment">	&lt;script&gt;!window.ieshiv && document.write(unescape(\'&lt;script src="' .H5BP_URL. '/js/ieshiv.js"&gt;&lt;/script&gt;\'))&lt;/script&gt;</code>';
				echo '<code class="comment">&lt;![endif]--&gt;</code>';
			}
		endif; // H5BP_modernizr_js_setting

		//	callback fn for H5BP_respond_js
		if ( ! function_exists( 'H5BP_respond_js_setting' ) ):
			function H5BP_respond_js_setting() {
				$options = get_option('plugin_options');
				$checked = (isset($options['H5BP_respond_js']) && $options['H5BP_respond_js']) ? 'checked="checked" ' : '';
				echo '<input class="check-field" type="checkbox" name="plugin_options[H5BP_respond_js]" value="true" ' .$checked. '/>';
				echo '<p><a href="http://filamentgroup.com/lab/respondjs_fast_css3_media_queries_for_internet_explorer_6_8_and_more/">Respond.js</a> is a JS library that helps IE<=8 understand <code>@media</code> queries, specifically <code>min-width</code> and <code>max-width</code>, allowing you to more reliably implement <a href="http://www.alistapart.com/articles/responsive-web-design/">responsive design</a> across all browsers.</p>';
				echo '<p>Selecting this option will add the following code to the <code class="html">&lt;head&gt;</code> of your pages (note the lack of a version, when you\'re ready to upgrade, simply copy/paste the new version into the file below, and your site is ready to go!):</p>';
				echo '<code class="comment">&lt;!--[if lt IE 9]&gt;&lt;script src="' .H5BP_URL. '/js/vendor/respond.js"&gt;&lt;/script&gt;&lt;![endif]--&gt;</code>';
			}
		endif; // respond_js_setting

		//	callback fn for H5BP_jquery_js
		if ( ! function_exists( 'H5BP_jquery_js_setting' ) ):
			function H5BP_jquery_js_setting() {
				$options = get_option('plugin_options');
				$checked = (isset($options['H5BP_jquery_js']) && $options['H5BP_jquery_js']) ? 'checked="checked" ' : '';
				$version = (isset($options['H5BP_jquery_version']) && $options['H5BP_jquery_version'] && $options['H5BP_jquery_version'] !== '') ? $options['H5BP_jquery_version'] : '1.8.3';
				$inhead = (isset($options['H5BP_jquery_head']) && $options['H5BP_jquery_head']) ? 'checked="checked" ' : '';
				echo '<input class="check-field" type="checkbox" name="plugin_options[H5BP_jquery_js]" value="true" ' .$checked. '/>';
				echo '<p><a href="http://jquery.com/">jQuery</a> is a JS library that aids greatly in developing high-quality JavaScript quickly and efficiently.</p>';
				echo '<p>Selecting this option will add the following code to your pages just before the <code class="html">&lt;/body&gt;</code>:</p>';
				echo '<code><b>&lt;</b>script src<b>=</b><span>"//ajax.googleapis.com/ajax/libs/jquery/'.$version.'/jquery.min.js"</span><b>&gt;&lt;/</b>script<b>&gt;</b></code>';
				echo '<code><b>&lt;</b>script<b>&gt;</b><span class="support">window</span>.<b>jQuery</b> <span class="html">||</span> <span class="support">document</span>.write<b>(</b>\'<span>&lt;script src="'.H5BP_URL.'/js/vendor/jquery.js"&gt;&lt;</span><b>\/</b><span>script&gt;\'</span><b>)&lt;/</b>script<b>&gt;</b></code>';
				echo '<p><input class="check-field" type="checkbox" name="plugin_options[H5BP_jquery_head]" value="true" ' .$inhead. '/>';
				echo '<strong>Note: <a href="http://developer.yahoo.com/blogs/ydn/posts/2007/07/high_performanc_5/">Best-practices</a> recommend that you load JS as close to the <code class="html">&lt;/body&gt;</code> as possible.  If for some reason you would prefer jQuery and jQuery plug-ins to be in the <code class="html">&lt;head&gt;</code>, please select this option.</strong></p>';
				echo '<p>The above code first tries to download jQuery from Google\'s CDN (which might be available via the user\'s browser cache).  If this is not successful, it uses the theme\'s version.</p>';
				echo '<p><strong>Note: This plug-in tries to keep current with the most recent version of jQuery.  If for some reason you would prefer to use another version, please indicate that version:</strong><br />';
				echo '<input type="text" size="6" name="plugin_options[H5BP_jquery_version]" value="'.$version.'"> (<a href="http://code.google.com/apis/libraries/devguide.html#jquery">see all versions available via Google\'s CDN</a>)</p>';
			}
		endif; // H5BP_jquery_js_setting

		//	callback fn for H5BP_plugins_js
		if ( ! function_exists( 'H5BP_plugins_js_setting' ) ):
			function H5BP_plugins_js_setting() {
				$options = get_option('plugin_options');
				$checked = (isset($options['H5BP_plugins_js']) && $options['H5BP_plugins_js']) ? 'checked="checked" ' : '';
				echo '<input class="check-field" type="checkbox" name="plugin_options[H5BP_plugins_js]" value="true" ' .$checked. '/>';
				echo '<p>If you would like to use any <a href="http://plugins.jquery.com/">jQuery plug-ins</a>, Boilerplate provides a starter file located in:</p>';
				echo '<code>' .H5BP_URL. '/js/plugins.js</code>';
				echo '<p>This allows you to maintain your own code that will not get overwritten during Theme updates.</p>';
				echo '<p><strong>I also recommend downloading and concatenating your plugins together in this single JS file.  This will <a href="http://developer.yahoo.com/performance/rules.html">reduce your site\'s HTTP Requests</a>, making your site a better experience.</strong></p>';
				echo '<p>Selecting this option will add the following code to your pages just before the <code class="html">&lt;/body&gt;</code>:</p>';
				echo '<code><b>&lt;</b>script src<b>=</b><span>\'' .H5BP_CHILD_URL. '/js/plugins.js?ver=x\'</span><b>&gt;&lt;</b>/script<b>&gt;</b></code>';
				echo '<p>(The single quotes and no-longer-necessary attributes are from WP, would like to fix that... maybe next update...)</p>';
				echo '<p><strong>Note: If you do <em>not</em> include jQuery, this file will <em>not</em> be added to the page.</strong></p>';
			}
		endif; // H5BP_plugins_js_setting

		//	callback fn for H5BP_site_js
		if ( ! function_exists( 'H5BP_site_js_setting' ) ):
			function H5BP_site_js_setting() {
				$options = get_option('plugin_options');
				$checked = (isset($options['H5BP_site_js']) && $options['H5BP_site_js']) ? 'checked="checked" ' : '';
				$inhead = (isset($options['H5BP_site_head']) && $options['H5BP_site_head']) ? 'checked="checked" ' : '';
				echo '<input class="check-field" type="checkbox" name="plugin_options[H5BP_site_js]" value="true" ' .$checked. '/>';
				echo '<p>If you would like to add your own site JavaScript file, Boilerplate provides a starter file located in:</p>';
				echo '<code>' .H5BP_URL. '/js/main.js</code>';
				echo '<p>This allows you to maintain your own code that will not get overwritten during Theme updates.</p>';
				echo '<p>Selecting this option will add the following code to your pages just before the <code>&lt;/body&gt;</code>:</p>';
				echo '<code><b>&lt;</b>script src<b>=</b><span>\'' .H5BP_URL. '/js/main.js\'</span><b>&gt;&lt;</b>/script<b>&gt;</b></code>';
				echo '<p>(The single quotes and no-longer-necessary attributes are from WP, would like to fix that... maybe next update...)</p>';
				echo '<p><input class="check-field" type="checkbox" name="plugin_options[H5BP_site_head]" value="true" ' .$inhead. '/>';
				echo '<strong>Note: <a href="http://developer.yahoo.com/blogs/ydn/posts/2007/07/high_performanc_5/">Best-practices</a> recommend that you load JS as close to the <code>&lt;/body&gt;</code> as possible.  If for some reason you would prefer your site-specific JS to be in the <code>&lt;head&gt;</code>, please select this option.</strong></p>';
			}
		endif; // H5BP_site_js_setting

		//	callback fn for H5BP_chrome_frame
		if ( ! function_exists( 'H5BP_chrome_frame_setting' ) ):
			function H5BP_chrome_frame_setting() {
				$options = get_option('plugin_options');
				$checked = (isset($options['H5BP_chrome_frame']) && $options['H5BP_chrome_frame']) ? 'checked="checked" ' : '';
				echo '<input class="check-field" type="checkbox" name="plugin_options[H5BP_chrome_frame]" value="true" ' .$checked. '/>';
				echo '<p>Prompt IE7 or less users to upgrade or install <a href="http://chromium.org/developers/how-tos/chrome-frame-getting-started">Chrome Frame</a>.</p>';
				echo '<p>Selecting this option will add the following code just after the <code class="html">&lt;body&gt;</code>:</p>';
				echo '<code class="comment">&lt;!--[if lt IE 8]&gt;&lt;p class=chromeframe&gt;You are using an &lt;em&gt;outdated&lt;/em&gt; browser. Please &lt;a href="http://browsehappy.com/"&gt;upgrade your browser&lt;/a&gt; or &lt;a href="http://www.google.com/chromeframe/?redirect=true"&gt;activate Google Chrome Frame&lt;/a&gt; to improve your experience.&lt;/p&gt;&lt;![endif]--&gt;</code>';
			}
		endif; // H5BP_chrome_frame_setting

		//	callback fn for H5BP_google_analytics_js
		if ( ! function_exists( 'H5BP_google_analytics_js_setting' ) ):
			function H5BP_google_analytics_js_setting() {
				$options = get_option('plugin_options');
				$checked = (isset($options['H5BP_google_analytics_js']) && $options['H5BP_google_analytics_js'] && isset($options['H5BP_google_analytics_account']) && $options['H5BP_google_analytics_account'] && $options['H5BP_google_analytics_account'] !== 'XXXXX-X') ? 'checked="checked" ' : '';
				$account = (isset($options['H5BP_google_analytics_account']) && $options['H5BP_google_analytics_account']) ? str_replace('UA-','',$options['H5BP_google_analytics_account']) : 'XXXXX-X';
				$msg = ($account === 'XXXXX-X') ? ', where </code>XXXXX-X</code> will be replaced with the code you insert above' : '';
				echo '<input class="check-field" type="checkbox" name="plugin_options[H5BP_google_analytics_js]" value="true" ' .$checked. '/>';
				echo '<p>To include Google Analytics, select this option and include your account number here:<br />(<strong>Note</strong>: This will not activate if default <strong>X</strong> value is present)<br />';
				echo 'UA-<input type="text" size="6" name="plugin_options[H5BP_google_analytics_account]" value="'.$account.'" onfocus="javascript:if(this.value===\'XXXXX-X\'){this.select();}" /></p>';
				echo '<p>Selecting this option will add the following code to your pages just before the <code class="html">&lt;/body&gt;</code>'.$msg.':</p>';
				echo '<code><b>&lt;</b>script<b>&gt;</b></code>';
				echo '<code>var <b>_gaq</b>=<b>[[</b><span>"_setAccount"</span><b>,</b><span>"UA-'.(($account !== 'XXXXX-X') ? $account : 'XXXXX-X').'"</span><b>],[</b><span>"_trackPageview"</span><b>]]</b>;</code>';
				echo '<code><b>(</b>function<b>(d,t){</b>var <b>g</b>=<b>d</b>.createElement<b>(t),s</b>=<b>d</b>.getElementsByTagName<b>(t)[</b><span class="constant">0</span><b>];</code>';
				echo '<code><b>g</b>.<span class="constant">src</span>=<b>(</b><span>"https:"</span>==<b>location</b>.<span class="constant">protocol</span><b>?</b><span>"//ssl"</span><b>:</b><span>"//www"</span><b>)</b>+<span>".google-analytics.com/ga.js"</span><b>;</b></code>';
				echo '<code><b>s</b>.<span class="constant">parentNode</span>.insertBefore<b>(g,s)}(</b><span class="support">document</span><b>,</b><span>"script"</span><b>));</b></code>';
				echo '<code><b>&lt;</b>/script<b>&gt;</b></code>';
				echo '<p><strong>Note: You must check the box <em>and</em> provide a UA code for this to be added to your pages.</strong></p>';
			}
		endif; // H5BP_google_analytics_js_setting


		//	callback fn for H5BP_search_form
		if ( ! function_exists( 'H5BP_search_form_setting' ) ):
			function H5BP_search_form_setting() {
				$options = get_option('plugin_options');
				$checked = (isset($options['H5BP_search_form']) && $options['H5BP_search_form']) ? 'checked="checked" ' : '';
				$placeholder = (isset($options['H5BP_search_placeholder_text']) && $options['H5BP_search_placeholder_text']) ? $options['H5BP_search_placeholder_text'] : '';
				echo '<input class="check-field" type="checkbox" name="plugin_options[H5BP_search_form]" value="true" ' .$checked. '/>';
				echo '<p>HTML5 allows numerous new input <code>type</code>s, including <code>type="search"</code>.  These new <code>type</code>s default to <code>type="text"</code> if the browser doesn\'t understand the new <code>type</code>, so there is no real penalty to using the new ones.  ';
				echo 'The new <code>search</code> also comes with a new <code>placeholder</code> attribute (sample text); to include <code>placeholder</code> text, type something here:<br />';
				echo '<input type="text" size="10" name="plugin_options[H5BP_search_placeholder_text]" value="'.$placeholder.'"></p>';
				echo '<p>Selecting this option will replace your existing <code>&lt;input type="text"...&gt;</code> with the following code on all of your pages:</p>';
				echo '<code>&lt;input type="search" placeholder="'.$placeholder.'"... /&gt;</code>';
			}
		endif; // H5BP_search_form_setting

		//	callback fn for H5BP_cache_buster
		if ( ! function_exists( 'H5BP_cache_buster_setting' ) ):
			function H5BP_cache_buster_setting() {
				$options = get_option('plugin_options');
				$checked = (isset($options['H5BP_cache_buster']) && $options['H5BP_cache_buster']) ? 'checked="checked" ' : '';
				$version = (isset($options['H5BP_cache_buster_version']) && $options['H5BP_cache_buster_version']) ? $options['H5BP_cache_buster_version'] : '1';
				echo '<input class="check-field" type="checkbox" name="plugin_options[H5BP_cache_buster]" value="true" ' .$checked. '/>';
				echo '<p>To force browsers to fetch a new version of a file, versus one it might already have cached, you can add a "cache buster" to the end of your CSS and JS files.  ';
				echo 'To increment the cache buster version number, type something here:<br />';
				echo '<input type="text" size="4" name="plugin_options[H5BP_cache_buster_version]" value="'.$version.'"></p>';
				echo '<p>Selecting this option will add the following code to the end of all of your CSS and JS file names on all of your pages:</p>';
				echo '<code>?ver='.$version.'</code>';
			}
		endif; // H5BP_cache_buster_setting

		//	callback for footer credit
		if ( ! function_exists( 'H5BP_footer_credit_setting' ) ):
			function H5BP_footer_credit_setting() {
				$options = get_option('plugin_options');
				$checked = (isset($options['H5BP_footer_credit']) && $options['H5BP_footer_credit']) ? 'checked="checked" ' : '';
				$business_name = (isset($options['your_business_name']) && $options['your_business_name']) ? $options['your_business_name'] : 'Your Business Name';
				$business_title = (isset($options['your_business_title']) && $options['your_business_title']) ? $options['your_business_title'] : 'Your Business Title';
				$website = (isset($options['your_business_website']) && $options['your_business_website']) ? $options['your_business_website'] : 'yourbusiness.com';
				$credit = (isset($options['your_business_credit']) && $options['your_business_credit']) ? $options['your_business_credit'] : 'maintained';
				$blog_title = get_bloginfo();
				echo '<input class="check-field" type="checkbox" name="plugin_options[H5BP_footer_credit]" value="true" ' .$checked. '/>';
				echo '<p>If you are developing a website for a client and want a linkback to your site in the footer, here\'s an easy way to give your business site credit. <strong>All fields are required</strong>.</p>';
				echo '<p><label for="business_name">Your Business Name: </label><input type="text" size="40" id="business_name" name="plugin_options[your_business_name]" value="'.$business_name.'" onfocus="javascript:if(this.value===\'Your Business Name\'){this.select();}" /></p>';
				echo '<p><label for="business_title">Your Business Title: </label><input type="text" size="40" id="business_title" name="plugin_options[your_business_title]" value="'.$business_title.'" onfocus="javascript:if(this.value===\'Your Business Title\'){this.select();}" /></p>';
				echo '<p><label for="business_website">Your Business URI (minus http://): </label><input type="text" size="40" id="business_website" name="plugin_options[your_business_website]" value="'.$website.'" onfocus="javascript:if(this.value===\'yourbusiness.com\'){this.select();}" /></p>';
				echo '<p><label for="business_credit">Your Business Credit: </label><input type="text" size="40" id="business_credit" name="plugin_options[your_business_credit]" value="'.$credit.'" onfocus="javascript:if(this.value===\'Your Business Credit\'){this.select();}" /></p>';
				echo '<p>The code will look like this:</p>';
				echo '<code><em>'.$blog_title.'</em> is '.$credit.' by &lt;a href=<span>"'.(($website !== 'yourbusiness.com') ? 'http://'.$website : 'http://yourbusiness.com').'"</span> title=<span>"'.(($business_title !== 'Your Business Title') ? $business_title : 'Your Business Title').'"</span>&gt;'.(($business_name !== 'yourbusiness.com') ? $business_name : 'Your Business Name').'&lt;/a&gt;</code>';
			}
		endif; // H5BP_footer_credit_setting


/*	4)	Create functions to add above elements to pages */

		//	$options['H5BP_google_chrome']
		if ( ! function_exists( 'H5BP_add_google_chrome' ) ):
			function H5BP_add_google_chrome() {
				echo '<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">'.PHP_EOL;
			}
		endif; // H5BP_add_google_chrome

		//	$options['H5BP_google_verification']
		if ( ! function_exists( 'H5BP_add_google_verification' ) ):
			function H5BP_add_google_verification() {
				$options = get_option('plugin_options');
				$account = $options['H5BP_google_verification_account'];
				echo '<meta name="google-site-verification" content="'.$account.'">'.PHP_EOL;
			}
		endif; // H5BP_add_google_verification

		//	$options['H5BP_viewport']
		if ( ! function_exists( 'H5BP_add_viewport' ) ):
			function H5BP_add_viewport() {
				$options = get_option('plugin_options');
				$setting = (isset($options['H5BP_viewport_setting']) && $options['H5BP_viewport_setting']) ? $options['H5BP_viewport_setting'] : 'width=device-width';
				echo '<meta name="viewport" content="'.$setting.'">'.PHP_EOL;
			}
		endif; // H5BP_add_viewport

		//	$options['H5BP_favicon']
		if ( ! function_exists( 'H5BP_add_favicon' ) ):
			function H5BP_add_favicon() {
				echo '<link rel="shortcut icon" href="/favicon.ico">'.PHP_EOL;
			}
		endif; // H5BP_add_favicon

		//	$options['H5BP_favicon_ithing']
		if ( ! function_exists( 'H5BP_add_favicon_ithing' ) ):
			function H5BP_add_favicon_ithing() {
				echo '<link rel="apple-touch-icon" sizes="144x144" href="/apple-touch-icon-144x144-precomposed.png" />'.PHP_EOL;
				echo '<link rel="apple-touch-icon" sizes="114x114" href="/apple-touch-icon-114x114-precomposed.png" />'.PHP_EOL;
				echo '<link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon-72x72-precomposed.png" />'.PHP_EOL;
				echo '<link rel="apple-touch-icon" sizes="57x57" href="/apple-touch-icon-57x57-precomposed.png" />'.PHP_EOL;
				echo '<link rel="apple-touch-icon" href="/apple-touch-icon-precomposed.png" />'.PHP_EOL;
				echo '<link rel="apple-touch-icon" href="/apple-touch-icon.png" />'.PHP_EOL;
			}
		endif; // H5BP_add_favicon_ithing

		//	$options['H5BP_modernizr_js']
		if ( ! function_exists( 'H5BP_add_modernizr_script' ) ):
			function H5BP_add_modernizr_script() {
				$cache = H5BP_cache_buster();
				wp_deregister_script( 'ieshiv' ); // get rid of IEShiv if it somehow got called too (IEShiv is included in Modernizr)
				wp_deregister_script( 'modernizr' ); // get rid of any native Modernizr
				echo '<script src="' .H5BP_URL. '/js/vendor/modernizr.js'.$cache.'"></script>'.PHP_EOL;
			}
		endif; // H5BP_add_modernizr_script

		//	$options['ieshiv_script']
		if ( ! function_exists( 'H5BP_add_ieshiv_script' ) ):
			function H5BP_add_ieshiv_script() {
				$cache = H5BP_cache_buster();
				echo '<!--[if lt IE 9]>'.PHP_EOL;
				echo '<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>'.PHP_EOL; // try getting from CDN
				echo '<script>window.html5 || document.write(\'<script src="' .H5BP_URL. '/js/ieshiv.js'.$cache.'"><\/script>\')</script>'.PHP_EOL; // fallback to local if CDN fails
				echo '<![endif]-->'.PHP_EOL;
			}
		endif; // H5BP_add_ieshiv_script

		//	$options['H5BP_respond_js']
		if ( ! function_exists( 'H5BP_add_respond_script' ) ):
			function H5BP_add_respond_script() {
				$cache = H5BP_cache_buster();
				echo '<!--[if lt IE 9]><script src="' .H5BP_URL. '/js/vendor/respond.js'.$cache.'"></script><![endif]-->'.PHP_EOL;
			}
		endif; // H5BP_add_respond_script

		//	$options['H5BP_jquery_js']
		if ( ! function_exists( 'H5BP_add_jquery_script' ) ):
			function H5BP_add_jquery_script() {
				$cache = H5BP_cache_buster();
				$options = get_option('plugin_options');
				$version = ($options['H5BP_jquery_version']) ? $options['H5BP_jquery_version'] : '1.8.3';
				wp_deregister_script( 'jquery' ); // get rid of WP's jQuery
				echo '<script src="//ajax.googleapis.com/ajax/libs/jquery/'.$version.'/jquery.min.js"></script>'.PHP_EOL; // try getting from CDN
				echo '<script>window.jQuery || document.write(\'<script src="' .H5BP_URL. '/js/vendor/jquery.js'.$cache.'"><\/script>\')</script>'.PHP_EOL; // fallback to local if CDN fails
			}
		endif; // H5BP_add_jquery_script

		//	$options['H5BP_plugins_js']
		if ( ! function_exists( 'H5BP_add_plugin_script' ) ):
			function H5BP_add_plugin_script() {
				$cache = H5BP_cache_buster();
				echo '<script src="' .H5BP_URL. '/js/plugins.js'.$cache.'"></script>'.PHP_EOL;
			}
		endif; // H5BP_add_plugin_script

		//	$options['H5BP_site_js']
		if ( ! function_exists( 'H5BP_add_site_script' ) ):
			function H5BP_add_site_script() {
				$cache = H5BP_cache_buster();
				echo '<script src="' .H5BP_URL. '/js/main.js'.$cache.'"></script>'.PHP_EOL;
			}
		endif; // H5BP_add_site_script

		//	$options['H5BP_search_form']
		if ( ! function_exists( 'H5BP_search_form' ) ):
			function H5BP_search_form( $form ) {
				$options = get_option('plugin_options');
				$placeholder = $options['H5BP_search_placeholder_text'];
				$form = '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
				<div><label class="screen-reader-text" for="s">' . __('Search for:') . '</label>
				<input type="search" placeholder="'.$placeholder.'" value="' . get_search_query() . '" name="s" id="s">
				<input type="submit" id="searchsubmit" value="'. esc_attr__('Search') .'">
				</div>
				</form>';
				return $form;
			}
		endif; // H5BP_search_form

		//	$options['H5BP_chrome_frame']
		if ( ! function_exists( 'H5BP_add_chrome_frame' ) ):
			function H5BP_add_chrome_frame() {
				echo '<!--[if lt IE 8]><p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p><![endif]-->'.PHP_EOL;
			}
		endif; // H5BP_add_chrome_frame

		//	$options['H5BP_google_analytics_js']
		if ( ! function_exists( 'H5BP_add_google_analytics_script' ) ):
			function H5BP_add_google_analytics_script() {
				$options = get_option('plugin_options');
				$account = $options['H5BP_google_analytics_account'];
				echo PHP_EOL.'<script>'.PHP_EOL;
				echo 'var _gaq=[["_setAccount","UA-'.str_replace('UA-','',$account).'"],["_trackPageview"]];'.PHP_EOL;
				echo '(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];'.PHP_EOL;
				echo 'g.src=("https:"==location.protocol?"//ssl":"//www")+".google-analytics.com/ga.js";'.PHP_EOL;
				echo 's.parentNode.insertBefore(g,s)}(document,"script"));'.PHP_EOL;
				echo '</script>'.PHP_EOL;
			}
		endif; // H5BP_add_google_analytics_script

		//	$options['H5BP_cache_buster']
		if ( ! function_exists( 'H5BP_cache_buster' ) ):
			function H5BP_cache_buster() {
				$options = get_option('plugin_options');
				return (isset($options['H5BP_cache_buster']) && $options['H5BP_cache_buster']) ? '?ver='.$options['H5BP_cache_buster_version'] : '';
			}
		endif; // H5BP_cache_buster

		//	$options['H5BP_footer_credit']
		if ( ! function_exists( 'H5BP_add_footer_credit' ) ):
			function add_footer_credit() {
				$options = get_option('plugin_options');
				$blog_title = get_bloginfo();
				$website = $options['your_business_website'];
				$business_title = $options['your_business_title'];
				$business_name = $options['your_business_name'];
				$credit = $options['your_business_credit'];
				echo $blog_title.' is '.$credit.' by <a href="http://'.$website.'" title="'.$business_title.'">'.$business_name.'</a>.';
			}
		endif; // H5BP_add_footer_credit



/*	5)	Add Boilerplate options to page as requested */
		if (!is_admin() ) {

			// get the options
			$options = get_option('plugin_options');

			// check if each option is set (meaning it exists) and check if it is true (meaning it was checked)
			if (isset($options['H5BP_google_chrome']) && $options['H5BP_google_chrome']) {
				add_action('wp_print_styles', 'H5BP_add_google_chrome');
			}

			if (isset($options['H5BP_google_verification']) && $options['H5BP_google_verification'] && $options['H5BP_google_verification_account'] && $options['H5BP_google_verification_account'] !== 'XXXXXXXXX...') {
				add_action('wp_print_styles', 'H5BP_add_google_verification');
			}

			if (isset($options['H5BP_viewport']) && $options['H5BP_viewport']) {
				add_action('wp_print_styles', 'H5BP_add_viewport');
			}

			if (isset($options['H5BP_favicon']) && $options['H5BP_favicon']) {
				add_action('wp_print_styles', 'H5BP_add_favicon');
			}

			if (isset($options['H5BP_favicon_ithing']) && $options['H5BP_favicon_ithing']) {
				add_action('wp_print_styles', 'H5BP_add_favicon_ithing');
			}

			if (isset($options['H5BP_modernizr_js']) && $options['H5BP_modernizr_js']) {
				add_action('wp_print_styles', 'H5BP_add_modernizr_script');
			} else {
				// if Modernizr isn't selected, add IEShiv inside an IE Conditional Comment
				add_action('wp_print_styles', 'H5BP_add_ieshiv_script');
			}

			if (isset($options['H5BP_respond_js']) && $options['H5BP_respond_js']) {
				add_action('wp_print_styles', 'H5BP_add_respond_script');
			}

			if (isset($options['H5BP_jquery_js']) && $options['H5BP_jquery_js'] && isset($options['H5BP_jquery_version']) && $options['H5BP_jquery_version'] && $options['H5BP_jquery_version'] !== '') {
				// check if should be loaded in <head> or at end of <body>
				$hook = (isset($options['H5BP_jquery_head']) && $options['H5BP_jquery_head']) ? 'wp_print_styles' : 'wp_footer';
				add_action($hook, 'H5BP_add_jquery_script');
			}

			// for jQuery plug-ins, jQuery must also be set
			if (isset($options['H5BP_jquery_js']) && $options['H5BP_jquery_js'] && isset($options['H5BP_jquery_version']) && $options['H5BP_jquery_version'] && $options['H5BP_jquery_version'] !== '') {
				// check if should be loaded in <head> or at end of <body>
				$hook = (isset($options['H5BP_jquery_head']) && $options['H5BP_jquery_head']) ? 'wp_print_styles' : 'wp_footer';
				add_action($hook, 'H5BP_add_jquery_script');
				// for jQuery plug-ins, jQuery must also be set
				if (isset($options['H5BP_plugins_js']) && $options['H5BP_plugins_js']) {
					add_action($hook, 'H5BP_add_plugin_script');
				}
			}

			if (isset($options['H5BP_search_form']) && $options['H5BP_search_form']) {
				add_filter( 'get_search_form', 'H5BP_search_form');
			}			

			if (isset($options['H5BP_chrome_frame']) && $options['H5BP_chrome_frame']) {
				add_action('ie_chrome_frame', 'H5BP_add_chrome_frame');
			}

			if (isset($options['H5BP_google_analytics_js']) && $options['H5BP_google_analytics_js'] && isset($options['H5BP_google_analytics_account']) && $options['H5BP_google_analytics_account'] && $options['H5BP_google_analytics_account'] !== 'XXXXX-X') {
				add_action('wp_footer', 'H5BP_add_google_analytics_script');
			}

			if (isset($options['H5BP_footer_credit']) && $options['H5BP_footer_credit'] && $options['H5BP_footer_credit'] !== '' ) {
				add_action('boilerplate_credits', 'H5BP_add_footer_credit');
			}


		} // if (!is_admin() )

/*	End customization for Boilerplate */

?>
