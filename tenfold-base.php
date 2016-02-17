<?php
/******************************************************************
Plugin Name:       Tenfold Base
Plugin URI:        http://tenfold.media
Description:       This plugin helps us set up WordPress for Tenfold Media clients.
Author:            Tim Rye
Author URI:        http://tenfold.media/tim
Version:           1.0.1
GitHub Plugin URI: TenfoldMedia/tenfold-base
GitHub Branch:     master
******************************************************************/

/* Required plugin setup */
require_once dirname( __FILE__ ).'/plugins.php';


/*********************
FRONT END HELPERS
*********************/

/* Redirect to '/blog/' base if permalink structure is set that way */
function tf_redirect_to_blog_base($template) {
	global $wp_rewrite, $wp_query;
	if (!is_404() || $wp_rewrite->permalink_structure !== '/blog/%postname%/') return $template;
	$url = '/blog'.parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
	if (!$postID = url_to_postid($url)) return $template;
	$url = get_permalink($postID).(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY) ? '?'.parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY) : '').(parse_url($_SERVER['REQUEST_URI'], PHP_URL_FRAGMENT) ? '#'.parse_url($_SERVER['REQUEST_URI'], PHP_URL_FRAGMENT) : '');
    wp_redirect($url, 301);
    exit;
}
add_filter('404_template', 'tf_redirect_to_blog_base');

/* Front-end footer credit helper funtion */
function tf_the_footer_credit($context_pre = 'Web Design by', $link_title = 'Web Design by Tenfold Media', $context_post = '', $chars = 5) {
	$url = 'http://tenfold.media/referral/?ref='.substr(preg_replace('#^www\.(.+\.)#i', '$1', $_SERVER['HTTP_HOST']), 0, $chars);
	echo ($context_pre ? $context_pre . ' ' : '') . '<a href="' . $url . '" rel="nofollow" target="_blank" title="' . $link_title . '">Tenfold Media</a>' . ($context_post ? ' ' . $context_post : '');
}

/*********************
CUSTOMISE ADMIN AREA
*********************/

// Show page / post ID column in admin
function tf_posts_columns_id($defaults) { $defaults['tf_post_id'] = 'ID'; return $defaults; }
function tf_posts_custom_id_columns($column_name, $id) { if ($column_name === 'tf_post_id') { echo $id; } }
add_filter('manage_posts_columns', 'tf_posts_columns_id', 5);
add_action('manage_posts_custom_column', 'tf_posts_custom_id_columns', 5, 2);
add_filter('manage_pages_columns', 'tf_posts_columns_id', 5);
add_action('manage_pages_custom_column', 'tf_posts_custom_id_columns', 5, 2);
add_filter('manage_media_columns', 'tf_posts_columns_id', 5);
add_action('manage_media_custom_column', 'tf_posts_custom_id_columns', 5, 2);

// Disable the plugin / theme editor
if (!defined('DISALLOW_FILE_EDIT')) { define('DISALLOW_FILE_EDIT', true); }


/*********************
CLEANUP
*********************/

// remove WP version from RSS
function tf_remove_wp_ver_rss() { return ''; }
// remove WP version from scripts
function tf_remove_wp_ver_css_js($src) { if (strpos($src, 'ver=')) $src = remove_query_arg('ver', $src); return $src; }

// remove the p from around imgs
function tf_filter_ptags_on_images($content){ return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content); }

// remove all sorts of unneccesary things (some using functions above)
function tf_cleanup() {
	remove_action('wp_head', 'feed_links_extra', 3);					// category feeds
	remove_action('wp_head', 'feed_links', 2);							// post and comment feeds
	remove_action('wp_head', 'rsd_link');								// EditURI link
	remove_action('wp_head', 'wlwmanifest_link');						// windows live writer
	remove_action('wp_head', 'index_rel_link');							// index link
	remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);	// links for adjacent posts
	remove_action('wp_head', 'wp_generator');							// WP version

	add_filter('the_generator', 'tf_remove_wp_ver_rss');				// remove WP version from RSS
	add_filter('style_loader_src', 'tf_remove_wp_ver_css_js', 9999);	// remove WP version from css
	add_filter('script_loader_src', 'tf_remove_wp_ver_css_js', 9999);	// remove WP version from scripts

	add_filter('the_content', 'tf_filter_ptags_on_images');				// cleaning up random code around images
}
add_action('after_setup_theme', 'tf_cleanup', 11);

// disable default dashboard widgets
function tf_disable_dashboard_widgets() {
	remove_meta_box('dashboard_quick_press', 'dashboard', 'core');			// Quick Draft widget
	remove_meta_box('dashboard_primary', 'dashboard', 'core');				// WordPress News widget

	update_user_meta(get_current_user_id(), 'show_welcome_panel', false);	// Remove the welcome panel
}
add_action('admin_menu', 'tf_disable_dashboard_widgets');

// dequeue Jetpack's 'devicepx' script (which is totally unneccesary and is a blocking script)
function remove_jetpack_devicepx() { wp_dequeue_script('devicepx'); }
add_action('wp_enqueue_scripts', 'remove_jetpack_devicepx', 20);
