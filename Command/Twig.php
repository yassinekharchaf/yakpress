<?php

class Twig extends YakPress
{
	public static function create($args, $assoc_args)
	{
		// Define the plugin path
		$plugin_dir = WP_PLUGIN_DIR . "/yakpress-twig";

		// Check if the plugin already exists
		if (is_dir($plugin_dir)) {
			WP_CLI::warning("yakpress-twig plugin is already installed");
			exit;
		}

		// Create the plugin folder folder
		wp_mkdir_p($plugin_dir);

		// Get the force flag
		$force = \WP_CLI\Utils\get_flag_value($assoc_args, 'force');

		// Create files inside the plugin
		$parent = new parent();
		$parent->create_files(array(
			"$plugin_dir/twig/yakpress-twig.php" => self::mustache_render('twig-plugin.mustache', []),
			"$plugin_dir/twig/env.php" => self::mustache_render('twig-env.mustache', []),
		), $force);

		// installing the twig librairy
		shell_exec("composer require \"twig/twig:^2.0\" -d $plugin_dir");
		//Activate the plugin
		// WP_CLI::runcommand("plugin activate yakpress-twig", []);

		// End of command
		WP_CLI::success("The Yakpress-twig plugin has been installed and activated.");
	}
}
