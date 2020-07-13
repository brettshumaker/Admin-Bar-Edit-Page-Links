Admin-Bar-Edit-Page-Links
=========================

WordPress plugin that adds an "Edit Content" item to the admin bar which contains a list (sorted by menu order) of every published post in a selected post type.

I created this because I was tired of having to click back to the "Pages" page while loading content into sites.

Usage
=====
* Activate plugin
* Visit "Admin Bar Edit Content Links" in the "Settings" menu.
* Check the boxes beside the post types you want to show
* Enjoy all the free time you now have

Filter
=======
`bs_abep_query_args`: allows you to edit the query args for the `get_posts()` call that lists the post types. This happens after `$args['post_type']` is set so you can have custom args per post type.

<p align="right"><a href="https://wordpress.org/plugins/admin-bar-edit-page-links/"><img src="https://img.shields.io/wordpress/plugin/dt/admin-bar-edit-page-links?label=wp.org%20downloads&style=for-the-badge">&nbsp;<img src="https://img.shields.io/wordpress/plugin/stars/admin-bar-edit-page-links?style=for-the-badge"></a></p>
