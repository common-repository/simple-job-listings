=== Simple Job Listings ===
Contributors: awbauer
Tags: 5hd, careers, job, listings
Requires at least: 3.0.1
Tested up to: 4.6
Stable tag: 4.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Simple Job Listings plugin. Real simple. 100% cruft-free.

== Description ==

An easy way to post job listings to your WordPress site. No fluff. Listings can be dropped into any page via the shortcode:

`[jobs order="title" show_date="y"]`

Also adds a restricted role of "Jobs Manager". This role is a step above Subscriber and a perfect way to grant access that doesn't allow (other) website content to be changed.


**Shortcode Attributes**

- `order` - Sort order of the jobs. Filterable on `jobslistings_frontend_allowed_sorts` (below.) Allows 'title', 'date', 'modified', 'rand' by default
- `show_date` - Wheter or not to show the publication/list date of the jobs (y/n)


**Filters**

- `jobslistings_frontend_allowed_sorts` (array) - Strings allowed to be passed to the shortcode's `order` attribute.
Full list of options [available in the Codex](https://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters)
- `joblistings_published_date` (string) - Formatted date for display in the listings. Also passes result of `get_the_date()` as a 2nd argument.


== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/simple-job-listings` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' screen in WordPress
1. Bask in the glory and simplicity of your new "Jobs" menu in `wp-admin`. 

== Screenshots ==

1. This screen shot description corresponds to screenshot-1.(png|jpg|jpeg|gif). Note that the screenshot is taken from
the /assets directory or the directory that contains the stable readme.txt (tags or trunk). Screenshots in the /assets 
directory take precedence. For example, `/assets/screenshot-1.png` would win over `/tags/4.3/screenshot-1.png` 
(or jpg, jpeg, gif).
2. This is the second screen shot

== Changelog ==

= 1.0 =
* First version! :wave: