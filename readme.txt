=== KIA Facebook Social Plugins ===
Contributors: Kathy Darling, Christopher Davis
Donate link: http://www.kathyisawesome.com/
Tags: facebook like button, facebook comments, facebook like box, facebook recommendations, facebook activity feed, facebook, widget, widgets
Requires at least: 3.3
Tested up to: 3.3
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

KIA Facebook Social Plugins adds 3 of the Facebook social plugins to WordPress as widgets: the Like Box, Recommendations, & the Activity Feed, as well as adding support for the Like Button and Facebook Commennts.

== Description ==

KIA Facebook Social Plugins is plugin that add three widgets to your WordPress arsenal: a Facebook Like Box, the Facebook Recommendations widget, and the Activity Feed.  This means you won't have to go to the [social plugin](http://developers.facebook.com/docs/plugins/ "social plugin") page anymore.  Additionally, the plugin lets you add a Like Button and Facebook-powered comments. 

This plugin is an update of Facebook Social Plugin Widgets by Christopher Davis at http://www.christopherguitar.net/ 
This plugin loads HTML5 versions instead of the XFBML versions of each of the social plugins, and includes the facebook `all.js` in the footer of your site.

== Installation ==

1. Download and unzip the `fb-sp-widgets.zip` file
2. Upload the `fb-social-widgets` folder to your plugins directory
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Add the widgets to your sidebar

== Frequently Asked Questions ==

= What about loading these things as iFrames? =

There is not currently support for this. 

= What sorts of things can I put in the "border color" inputs? =

Border color can be a color name (like "red" or "blue") or a hex color code (like #CCCCCC).

= Why don't my widgets work in Internet Explorer? =

IE does a funny thing.  It requires the `<head>` tag to have a special attribute: `xmlns:fb="http://www.facebook.com/2008/fbml"`. FBSPW adds this via a filter on [language attributes](http://codex.wordpress.org/Function_Reference/language_attributes).  You must have this in your theme's `header.php` file to make this work:

`<html <?php language_attributes(); ?>>`

== Screenshots ==

1. The Like Box widget options
2. Activity Feed widget options
3. Recommendations widget options

== Changelog ==

= 1.0 =
* The first release!
* Supports the facebook like box, activity feed, and recommendations as widgets
* completely replaces your comments.php template with Facebook Comments
* adds Like Button to the_content
