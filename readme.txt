=== Admin Bar Edit Content Links ===
Contributors: brettshumaker
Donate link: http://brettshumaker.com/
Tags: edit page, page links, admin bar, page
Requires at least: 3.0
Tested up to: 4.4.2
Stable tag: 1.4.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A simple plugin that adds a drop down list of post types to the admin bar.

== Description ==

Adds an Edit Content link to the WordPress admin bar so you can quickly jump between editing pages, posts, and other custom post types. Very helpful if you're doing a lot of content editing.


== Installation ==

1. Upload the `admin-bar-edit-page-links` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. That's it!

== Frequently Asked Questions ==

= How do I add other post types to the drop down? =
Click on 'Admin Bar Edit Content Links' in the 'Settings' menu on the left. Then check the box beside the post types you want to show and click 'Save Changes.'

[Visit the Admin Bar Edit Content Links support section to ask a question!](http://wordpress.org/support/plugin/admin-bar-edit-page-links "Admin Bar Edit Page Links support")

== Screenshots ==

1. Admin Bar Edit Content Links settings menu

2. The menu in action

== Changelog ==

= 1.4.1 =
* Moved to using `WP_Query` instead of `get_posts`.
* Fixed bug with default ordering. Children were not always shown below their parents and some grandchildren or great grandchildren, etc. were missing.
* Note: Hierarchical sorting goes away if you change the `orderby` parameter away from `menu_order`

= 1.4.0 =
* Changed versioning system at 1.1.0 and plugin update was not triggered. This is just a version bump to trigger an update.

= 1.1.1 =
* Moved location of the filter 'bs_abep_query_args' - now you can check for the post type while filtering
* Added in 'posts_per_page' to the query args - inadvertently left that out in 1.1.0

= 1.1.0 =
* Added ability to add multiple post types to the menu
* Minor housekeeping things

= 1.04 =
* Fixed: Undefined variable PHP Notice
* Added: Translation support

= 1.03 =
* Fixed: Pre 3.8 users would not get page list
* Minor CSS tweak for pre 3.8 users

= 1.02 =
* Updated icon to use the dashicon in 3.8 with an image fallback for older versions
* General CSS update

= 1.01 =
* Remove testing code

= 1.0 =
* Initial Plugin Launch