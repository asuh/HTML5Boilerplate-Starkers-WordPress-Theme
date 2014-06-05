=== Theme Name ===
Contributors: aarontgrogg
Tags: html5, boilerplate
Requires at least: 3.1
Tested up to: 3.5.1
Stable tag: 4.4.2

Based on the [HTML5 Boilerplate](http://html5boilerplate.com/) created by
[Paul Irish](http://paulirish.com/) and [Divya Manian](http://nimbupani.com/),
this plug-in allows for easy inclusion and removal of all HTML5 Boilerplate options
that are pertinent to WP.

This theme might look like a little bit of a quagmire at first blush because
it is a merger of two great themes with a very minor bit by me, but stay
with me, it'll all make sense in a bit, I promise.

More about this theme can be found at http://aarontgrogg.com/boilerplate/

== Description ==

Standing on the foreheads of giants (namely [Paul Irish](http://paulirish.com/)
and [Divya Manian](http://nimbupani.com/) and the good folks that have helped
them create and continue the growth of HTML5 Boilerplate, I present to you my
first WordPress theme, [Boilerplate - Starkers WP Theme](http://aarontgrogg.com/boilerplate/).

The clumsiest part of this is dealing with the Boilerplate CSS and JS files.
To avoid any changes you make from being overwritten during upgrades,
"starter" files have been created in the `/css` and `/js` directories.  I recommend
creating copies of the starter files (removing '-starter' from the new filenames)
that you can safely edit.  That way, if the starter files are updated later, you can
simply copy/paste from them into your files again, and all is fine.

Another route would be to add additional links in your pages, but this does increase
your HTTP Requests, which hurts performance...
Your call, let me know if you can think of a better implementation.

More about this theme can be found at:
http://aarontgrogg.com/boilerplate/

I also built a Boilerplate plug-in that can be found at:
http://aarontgrogg.com/html5boilerplate/.
The plug-in can be added to any existing or new theme, allowing the easy additional of
all the delicious HTML5 Boilerplate goodness with the ease of checking checkboxes.

Please let me know if you have any questions/suggestions/thoughts,

Atg
http://aarontgrogg.com/
aarontgrogg@gmail.com


== Installation ==

1. Download the ZIP
2. Unzip the ZIP
3. Copy/paste the unzipped files into your WP themes directory (`/wp-content/themes/`)
4. From within WP's Themes Admin panel, Activate the Boilerplate theme
5. In the left-nav, within the Appearance menu, you should now have an HTML5 Boilerplate link
6. Click the link to view the HTML5 Boilerplate Admin panel
7. Check and un-check options to add and remove stuff from your site!


== Frequently Asked Questions ==

= What HTML5 Boilerplate options does the theme add? =
* Use HTML5 `DOCTYPE`?
* Add IE Conditional `<html>` Tags?
* Move XFN profile from `<head>` to `<link>`?
* Use HTML5 Character-Encoding `<meta>` Tag?
= What HTML5 Boilerplate options does the theme let me manipulate? =
* Kill IE6 Image Toolbar?
* Force IE-edge / Google Chrome?
* Add Google Verification?
* Force iThings to Use Full Zoom?
* Add Favicon?
* Add iThing Favicon?
* Add IE-only CSS file?
* Add Modernizr JS?
* Add Respond JS?
* Add jQuery JS?
* Which jQuery version?
* Put jQuery in `<head>` or at end of `<body>`?
* Add jQuery Plug-ins JS?
* Add Site-specific JS?
* Use HTML5 Search `<input>` Type?
* Add Search `placeholder` Text?
* Add Cache Buster to CSS &amp; JS Files?


== Screenshots ==

1. Admin Screen
2. View Source Before HTML5 Boilerplate
3. View Source After HTML5 Boilerplate


=== Change Log ===

= 4.4.2 2013-04-22 =
* Updated <h2> to <h1> in main index loop, and wrapped <h1>s in <header>

= 4.4.1 2013-08-28 =
* MASSIVE aplogies, there was a bug in one of my pages (a missing '), it is fixed now...  thanks and apologies to mediagrin for pointing it out so quickly!

= 4.4 2013-08-25 =
* Tested for WP 3.6
* Upgraded jQuery to 1.10.2
* Updated main.css to latest version
* Updated all H5BP doc files
* Added dir="<?php bloginfo('text_direction'); ?>" to <html> tag(s)
* Added Serbian translation files, big thanks to Andrijana Nikolic!
* Added example "remove no-js" script to script-starter.js

= 4.3.2 2013-06-01 =
* Removing Git files....

= 4.3.1 2013-05-23 =
* Trying to convince the uploader to upload...

= 4.3 2013-05-23 =
* Big thanks to FrŽdŽric Bolduc for pointing out that jQuery was being added twice, once from the Google CDN,
  then again the local version, because I had `!window.jQuery || ...` instead of `window.jQuery || ...`  Doh!
* And speaking of jQuery, updated the local version to 1.9.1.
* Update to version 4.2.0 of HTML5 Boilerplate, including:
  * `style.css` now reflects latest `/css/normalize.css` and `/css/main.css`
  * all `/doc` files
  * `/js/plugins-starter.js` now reflects latest `/js/plugins.js`
  * `/js/ieshiv.js` now uses `html5shiv-printshiv.js`, which includes additional stuff for printing: https://github.com/aFarkas/html5shiv
  * `/js/respond.js` uses the latest version from: https://github.com/scottjehl/Respond
* Thanks to Sophie for the French translation files!
* Added a few minor enhancements based on personal use of this Theme
* Seems Screenshots do not work for Themes?  Well, I'll add them in an `/assets` directory anyway, you never know, maybe some day...

= 4.2 2013-01-12 =
* Tested & verified in WP 3.5

= 4.1 2012-11-14 =
* Fixed an issue where the `ieshiv.js` was getting applied to a page 2-3 times in IE < 9...  erps!

= 4.0.1 2012-10-05 =
Let's try that again...

= 4.0 2012-09-28 =
NOTE:
  I find myelf at a very troublesome crossroads with the good folks of HTM5Boilerplate project...
  With the release of their 4.0, they have greatly changed a number of structure items, such as directory and file names
  that will work just fine for their project, because it is intended as a starting point for new projects, but is somewhat
  problematic for things like WP Themes & Plugins, as they tend to serve initially as starting points, but then quickly become
  something that must be updatable, and therefore be backwards-compatible...  And splitting `/css/style.css` into `/css/normalize.css`
  and `/css/main.css` could cause issues for developers already using a Theme/Plugin.  So, in the interest of my users, I am staying
  with the old directory and file names, regardless of the additional work this will cause me.  I hope this doesn't confuse anyone...

* Updated jQuery to 1.8.2
* Updated Modernizr to 2.6.2
* Updated `/css/style-starter.css` to latest HTML5 Boilerplate version (combination of `/css/normalize.css` and `/css/main.css`)
* Updated `/js/plugins.js` to latest HTML5 Boilerplate version
* Updated `/js/respond.js` to latest version: https://github.com/scottjehl/respond (keeping this separate from Modernizr, as you might only want one)
* Updated `/js/ieshiv.js` to latest version: https://raw.github.com/aFarkas/html5shiv
* Updated `functions.php` to replace functions `add_custom_image_header` & `add_custom_background` (deprecated as of 3.4) with `add_theme_support`
* Added `/js/plugins-starter.js` file to prevent overwrites during Theme upgrades
* Added ability to force custom site-specific JS into the `&lt;head&gt;` instead of before the `&lt;/body&gt;`
* Added "H5BP_" namespace to all functions & `plugin_options` names in `admin-menu.php`
* Added `if ( ! function_exists( ... ) )` to all functions in `admin-menu.php`
* Added `&lt;link rel="apple-touch-icon" sizes="144x144" href="/apple-touch-icon-144x144.png"&gt;` option
* Added `/doc` directory from latest HTML5 Boilerplate version
* Added `readme.md` from latest HTML5 Boilerplate version
* Added "Check All | Uncheck All" links to top of BP Admin form
* Added Espanol translation, muchos gracias otra vez a Benjamin Arnedo!
* Restored `get_header_image` to `header.php`, not sure why that was missing; thanks to Ted Thompson!
* Reordered apple-touch-icon links per H5BP docs; thanks once again, Micah!
* Moved the `boilerplate_search_form` function from `functions.php`, where it happened automatically, to an option in the Boilerplate Admin, and renamed it as `H5BP_search_form`


= 3.4.4 2012-03-10 =

Fixing a bad URL in several custom CSS and JS strings, where:
...`BP_THEME_URL. 'js`...
should have been:
...`BP_THEME_URL. '/js`...
Muchas gracias a Benjamin Arnedo!


= 3.4.3 2012-03-01 =

Updated admin-menu.php to permit the Boilerplate Theme and HTML5 Boilerplate Plug-in to exist side-by-side.  In this case, the Plug-in functionality will persist and the Theme functionality will lie dormant.


= 3.4.2 2012-02-25 =

Removed boilerplate_category_id_class from functions.php; if you want this functionality, I recommend installing this plug-in:
  http://wordpress.org/extend/plugins/add-url-slugs-as-body-classes/

Altered boilerplate_posted_on function to reflect three Archive links rather than a single permalink to Post; thanks to Alexander Bailey for the idea!


= 3.4.1 2012-02-24 =

(I bumped-up the version number a bit to match the HTML5 Boilerplate Plug-in numbering.)
* Converted `... />` to  `...>` for all the stuff this plug-in writes to the page.
* Updated `/css/style-starter.css` to latest HTML5 Boilerplate version.
* Updated jQuery to 1.7.1.
* Updated Modernizr to 2.5.3, Custom Build.
* Added 57x57 iThing favicon link.
* Fixed Bug introduced by WP 3.3+ that causes jQuery to be loaded after site-specific JS.


= v.3.0 2011-06-02 =

Fixed error in header.php, I was applying `boilerplate_filter_wp_title` as a `filter` to `wp_title` in functions.php,
but then calling `boilerplate_filter_wp_title` in header.php, rather than `wp_title`... der...  Thanks, Randy Runnels!

Per Paul & Divya recommendations:
- Dropping cdnjs link for Modernizr, resorting to local link only, hopefully soon that will be replaced with Google CDN link.
- Removed handheld.css, because "our research has shown not enough devices read it to make it worthwhile". Additionally, if you're doing your CSS right (a la Responsive Design, you're building for smaller screens first, then adding CSS for larger screens via `@media` queries, right?).
- Removed print.css because "extra print stylesheets are downloaded at load, so its a big hit"; this, too, is best served via `@media` queries in your main CSS.
- Removed YUI Profiling stuff because you "probably weren't using it anyway", right?
- Removed Belated PNG because it "is a really slow solution and an overkill for PNGs", check [http://html5boilerplate.com/docs/#Notes-on-using-PNG](http://html5boilerplate.com/docs/#Notes-on-using-PNG) for deets on dealing with PNGs in ye olde IE.

Added removal of IE6 Image Toolbar option to Admin panel.

Added [Google Verification](http://www.google.com/support/webmasters/bin/answer.py?answer=35179) option to Admin panel.

Added iPad and iPhone 4 favicon links to existing "iThing Favicon" block.

Added [Respond.js](http://filamentgroup.com/lab/respondjs_fast_css3_media_queries_for_internet_explorer_6_8_and_more/) option to Admin panel.

Added cache-buster option in Admin panel, allowing you to either include, and easily increment, a cache-buster / version number to any theme CSS or JS files.

Updated `/style.css` to latest HTML5 Boilerplate version.

Updated jQuery to 1.6.1.

Updated `/js/plugins.js` to include `console.log` bit.


= v.2.1.8 2011-05-08 =

Attempting to clear issues WP is having with Boilerplate CSS.

Changed Boilerplate Admin CSS filename from style.css to admin-style.css.

Updated jQuery to 1.6.

Miscellaneous updates from http://html5boilerplate.com/, including CSS and JS files.

Removed _READ_ME.txt (from Starkers theme) and README.markdown (from HTML5 Boilerplate), if you need to read them,
check the respective sites for them.

Enhanced this readme.txt file a little, for your reading pleasure.

// Moved Boilerplate Admin link from Themes to Settings (seem like that's where it ought to be, right?).
// Nope, automated upload process insists any admin pages be in the Themes section...

Enhanced Boilerplate Admin panel, offering slightly improved explanations.

// Trying once again to get WP to allow the inclusion of Google Analytics block option in Boilerplate Admin panel.
// Nope, automated upload process still blocks any reference to this...


= v.2.1.4 2011-01-14 =

Removed extraneous > in 404.php (thanks, Dominic!)

Miscellaneous updates from http://html5boilerplate.com/

Per WP, reduced size of screenshot.png.


= v.2.1 2010-11-14 =

Per WP, changed screenshot.png to reflect visual representation of site, not HTML4 Boilerplate logo.

Added additional classes (ie, lte7, lte8, lte9, where appropriate) to IE Conditional Comments in wrap <html> block.

Removed extraneous (explanatory) comments from HTML, hopefully you'll get it, if not, refer to HTML5 Boilerplate documentation (https://github.com/paulirish/html5-boilerplate/wiki).

Expanded Admin Page content, adding text and links to help users understand each option more clearly.

Removed the following from header.php and added as optional items on the Admin page:
- <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
- <meta name="viewport" content="width=device-width, initial-scale=1.0">
- <link rel="shortcut icon" href="/favicon.ico">
- <link rel="apple-touch-icon" href="/apple-touch-icon.png">

Added an option to the Admin page to include an IE-only CSS.

A few people recommended changing third-party links (Modernizr, jQuery, etc.) to Google repository.
I went back-and-forth on this, whether it made more sense to link to Google's repository (possible caching benefits, definite CDN benefits),
or whether it made more sense to give the developer the ability to control their own assets and serve from local files.
In the end, I went with local versions, mostly for version-control, but also because I figure if Google goes down, it could hurt your site;
if your site is down, whether JS is available isn't exactly your biggest problem...
In some future version I'd like to make both options available via the Admin page...
It would be fairly easy to change these paths if you wanted, in /wp-content/themes/boilerplate/boilerplate-admin/admin-menu.php, under "Create functions to add above elements to pages"

A few recommendations gratefully accepted from Micah (http://www.twolanedesign.com/):
- If Modernizr is unchecked, IEShiv will be added (inside an IE conditional comment).
- Add Async Google Analytics option to Admin Page.
  * Appears WP doesn't like GA, so this has been removed, but check here for instructions () on how to add it back in once you've downloaded Boilerplate...
- Removing WP version number via functions.php (http://digwp.com/2009/07/remove-wordpress-version-number/)
- Also recommended these two links which do contain some great scripts, but kind of go against the idea of Starkers (that less-is-more).
  You can easily add anything you like to the functions.php:
  http://digwp.com/2010/03/wordpress-functions-php-template-custom-functions/
  http://digwp.com/2010/04/wordpress-custom-functions-php-template-part-2/

Grabbed updated assets (css, js, etc.) from github per:
- http://github.com/paulirish/html5-boilerplate/compare/v0.9...v0.9.1
- http://github.com/paulirish/html5-boilerplate/compare/v0.9.1...v0.9.5


= v.2.0.1 2010-10-06 =

Boilerplate starts with the Starkers theme (http://starkerstheme.com/)...
  mixes in HTML5 Boilerplate (http://html5boilerplate.com/)...
  then makes a couple minor modifications...
  1) moved IE conditionals from <boby> to <html>, to better synch with Modernizr...
  2) above also allowed me to remove the <!--[if IE]><![endif]--> recommended by www.phpied.com/conditional-comments-block-downloads/...
  3) moved extraneous items (like Modernizr, jQuery, Belated PNG, etc.) to Admin panel (not the last item in the Settings drop-down)...
  The only extraneous items left in the mark-up are the two favicon references in header.php; read about it there.

* The directory "- MOVE TO ROOT" is filled with HTML5 Boilerplate goodness that
  should be copied FROM that directory and pasted TO your blog's root directory.
* The .htaccess in that directory is filled with things which I honestly do not understand...
  I had to comment-out several items in order to get my WP installation to work, so, play if you like.

Be sure to read these "read me" type files as well:
  - _READ_ME.txt and _LICENSE.txt are from Starkers Theme
  - README.markdown is from HTML5 Boilerplate


= v.1.0 2010-10-01 =

Was pure crap, please ignore...
