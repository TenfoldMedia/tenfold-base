<?php
/******************************************************************
Plugin Name:       Tenfold Base
Plugin URI:        http://tenfold.media
Description:       This plugin helps us set up WordPress for Tenfold Media clients.
Author:            Tim Rye
Author URI:        http://tenfold.media/tim
Version:           1.0.0
GitHub Plugin URI: TenfoldMedia/tenfold-base
GitHub Branch:     master
******************************************************************/

/* Required plugin setup */
require_once dirname( __FILE__ ).'/plugins.php';


/* Redirect to '/blog/' base */
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
