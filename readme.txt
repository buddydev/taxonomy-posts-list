=== Taxonomy Posts List ===
Contributors: buddydev,sbrajesh
Tags: wordpress, wordpress category, wordpress custom category
Requires at least: 4.0+
Tested up to: 4.9.1
Stable tag: 1.0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Taxonomy posts list plugin allows you to list posts from a category, custom taxonomy or custom post type using a simple shortcode on your WordPress based website.

== Description ==

Taxonomy posts list plugin allows you to list posts from a category, custom taxonomy or custom post type using a simple shortcode on your WordPress based website.

Features:-

* List all posts from a category inside  a post.
* List limited no. of posts from a category inside a post.
* List all custom post types inside a post.
* List all attachment.
* List all/limited number of posts from any taxonomy.
* Lists all/limited no. of posts from any taxonomy, custom post type

Here is how do you use it. You can use any of the three shortcodes whichever you like to list the posts  [category_toc], [term_toc] or [taxonomy-posts-list] .  I personally prefer the first one for post categories and last one while using custom taxonomies. These three are exactly same and just aliases. I was not sure which one sounds better, so created three aliases.
Here are the various options available with the shortcode.

Shortcode Options:-
* max: [optional] maximum no of posts to list, you can use it like max=’5′ to list 5 posts. If you do not specify, all posts for the taxonomy/post type will be listed depending on below conditions.
* term: [optional] The category or taxonomy term slug. eg. term=’love’ to find all the posts tagged in category love. If you do not specify a term, the first term from the current post will be taken.
* taxonomy: [optional] You can specify custom taxonomies like events like this taxonomy=’events’, By default, the taxonomy is set to be post categories.
* post_type: [optional] You can specify the posts from which post type which should be listed. By default, It is set to the post type of current post.

**For Support**, Please use [BuddyDev Support Forums](https://buddydev.com/support/forums/ ).

== Installation ==

1. Visit Dashboard->Plugins->add New
2. Search for Taxonomy Posts List
3. Install this plugin
4. Click Activate
5. Now, You can use shortcodes.

For more details, Please see the plugin documentation page.

== Screenshots ==

1. Posts listing screenshot-1.png

== Changelog ==

= 1.0.1 =
* Updated to fix the terms error and cleanup.

= 1.0.0 =
* initial release
