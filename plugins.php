<?php

require_once dirname( __FILE__ ).'/class-tgm-plugin-activation.php';

function tf_register_required_plugins() {

	$plugins = array(
		array(
			'name'             => 'GitHub Updater',
			'slug'             => 'github-updater',
			'source'           => 'https://github.com/afragen/github-updater/archive/master.zip',
			'required'         => true, // If false, the plugin is only 'recommended' instead of required.
			'force_activation' => true, // If set to true, it forces the specified plugin to be active at all times while the current theme or plugin is active.
		),
		array(
			'name'             => 'Tenfold Base',
			'slug'             => 'tenfold-base',
			'source'           => 'https://github.com/TenfoldMedia/tenfold-base/archive/master.zip',
			'required'         => true, // If false, the plugin is only 'recommended' instead of required.
			'force_activation' => true, // If set to true, it forces the specified plugin to be active at all times while the current theme or plugin is active.
		),
		array(
			'name'             => 'Tenfold White Label',
			'slug'             => 'tenfold-white-label',
			'source'           => 'https://github.com/TenfoldMedia/tenfold-white-label/archive/master.zip',
			'required'         => true, // If false, the plugin is only 'recommended' instead of required.
			'force_activation' => true, // If set to true, it forces the specified plugin to be active at all times while the current theme or plugin is active.
		),
		/*array(
			'name'             => 'Tenfold Custom CSS & JS',
			'slug'             => 'tenfold-custom-css-js',
			'source'           => 'https://github.com/TenfoldMedia/tenfold-custom-css-js/archive/master.zip',
			'required'         => false, // If false, the plugin is only 'recommended' instead of required.
			'force_activation' => false, // If set to true, it forces the specified plugin to be active at all times while the current theme or plugin is active.
		),*/

		array(
			'name'      => 'Admin Menu Editor',
			'slug'      => 'admin-menu-editor',
		),
		array(
			'name'      => 'Advanced Custom Fields',
			'slug'      => 'advanced-custom-fields',
		),
		array(
			'name'      => 'Advanced Custom Fields: Code Area',
			'slug'      => 'advanced-custom-fields-code-area-field',
		),
		array(
			'name'      => 'Akismet',
			'slug'      => 'akismet',
		),
		array(
			'name'      => 'Autoptimize',
			'slug'      => 'autoptimize',
		),
		array(
			'name'      => 'Block Referer Spam',
			'slug'      => 'block-referer-spam',
			'required'  => true,
			'force_activation' => true,
		),
		array(
			'name'      => 'Broken Link Checker',
			'slug'      => 'broken-link-checker',
		),
		array(
			'name'      => 'Cookie Consent',
			'slug'      => 'uk-cookie-consent',
		),
		array(
			'name'      => 'Duplicate Post',
			'slug'      => 'duplicate-post',
		),
		array(
			'name'      => 'Google Analyticator',
			'slug'      => 'google-analyticator',
		),
		array(
			'name'      => 'Jetpack by WordPress.com',
			'slug'      => 'jetpack',
		),
		array(
			'name'      => 'Media File Renamer',
			'slug'      => 'media-file-renamer',
		),
		array(
			'name'      => 'Redirection',
			'slug'      => 'redirection',
		),
		array(
			'name'      => 'Simple Page Ordering',
			'slug'      => 'simple-page-ordering',
		),
		array(
			'name'      => 'Stream',
			'slug'      => 'stream',
		),
		array(
			'name'      => 'WP Retina 2x',
			'slug'      => 'wp-retina-2x',
		),
		array(
			'name'      => 'Yoast SEO',
			'slug'      => 'wordpress-seo',
		),
	);

	$config = array(
		'id'           => 'tenfold-base',			// Unique ID for hashing notices for multiple instances of TGMPA.
		'menu'         => 'tf-install-plugins',		// Menu slug.
		'parent_slug'  => 'plugins.php',            // Parent menu slug.
		'capability'   => 'manage_options',			// Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'is_automatic' => true,						// Automatically activate plugins after installation or not.
		'strings'      => array(
			'notice_can_install_required'     => _n_noop(
				'Tenfold Media requires the following plugin be installed: %1$s.',
				'Tenfold Media requires the following plugins be installed: %1$s.',
				'tenfold-base'
			), // %1$s = plugin name(s).
			'notice_can_install_recommended'  => _n_noop(
				'Tenfold Media recommends the following plugin: %1$s.',
				'Tenfold Media recommends the following plugins: %1$s.',
				'tenfold-base'
			), // %1$s = plugin name(s).
			'notice_ask_to_update'            => _n_noop(
				'The following plugin needs to be updated to its latest version: %1$s.',
				'The following plugins need to be updated to their latest version: %1$s.',
				'tenfold-base'
			), // %1$s = plugin name(s).
			'plugin_needs_higher_version'     => __( 'Plugin not activated. Tenfold Media requires a higher version of %s. Please update the plugin.', 'tenfold-base' ),  // %1$s = plugin name(s).

			'nag_type'                        => 'error', // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
		),
	);

	tgmpa( $plugins, $config );

}
add_action('tgmpa_register', 'tf_register_required_plugins');
