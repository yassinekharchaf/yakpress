<?php

class YakPress extends Scaffold_Command
{

	/**
	 * Create a plugin as a micro framework which will be prefilled with files
	 *
	 * ## OPTIONS
	 *
	 * <name>
	 * : The name of the plugin
	 *
	 */
	public function create_plugin($args, $assoc_args)
	{
		$plugin_slug    = $args[0];
		$plugin_namespace = ucwords($plugin_slug);
		$plugin_name    = ucwords(str_replace('-', ' ', $plugin_slug));
		$plugin_package = str_replace(' ', '_', $plugin_name);


		$data = wp_parse_args($assoc_args, array(
			'plugin_slug'         => $plugin_slug,
			'plugin_namespace' 		=> $plugin_namespace,
			'plugin_name'         => $plugin_name,
			'plugin_package'      => $plugin_package,
			'plugin_description'  => 'PLUGIN DESCRIPTION HERE',
			'plugin_author'       => 'YOUR NAME HERE',
			'plugin_author_uri'   => 'YOUR SITE HERE',
			'plugin_uri'          => 'PLUGIN SITE HERE',
			'plugin_tested_up_to' => get_bloginfo('version'),
			'textdomain'					=> $plugin_slug,
			'plugin_prefix' 			=> strtoupper(substr($plugin_slug, 0, 3)),
		));

		$plugin_dir = WP_PLUGIN_DIR . "/$plugin_slug";
		$force = \WP_CLI\Utils\get_flag_value($assoc_args, 'force');

		wp_mkdir_p("$plugin_dir/$plugin_namespace");
		wp_mkdir_p("$plugin_dir/$plugin_namespace/Databases");
		wp_mkdir_p("$plugin_dir/$plugin_namespace/Databases/Migrations");
		wp_mkdir_p("$plugin_dir/$plugin_namespace/Features");
		wp_mkdir_p("$plugin_dir/$plugin_namespace/Http");
		wp_mkdir_p("$plugin_dir/$plugin_namespace/Http/Controllers");
		wp_mkdir_p("$plugin_dir/$plugin_namespace/Http/Middlewares");
		wp_mkdir_p("$plugin_dir/$plugin_namespace/Http/Models");
		wp_mkdir_p("$plugin_dir/$plugin_namespace/Http/Requests");
		wp_mkdir_p("$plugin_dir/$plugin_namespace/Providers");
		wp_mkdir_p("$plugin_dir/config");
		wp_mkdir_p("$plugin_dir/resources");
		wp_mkdir_p("$plugin_dir/resources/assets");
		wp_mkdir_p("$plugin_dir/resources/views");
		wp_mkdir_p("$plugin_dir/routes");


		$this->create_files(array(
			"$plugin_dir/$plugin_namespace/Databases/Database.php" => self::mustache_render('databases-database.mustache', $data),
			"$plugin_dir/$plugin_namespace/routes/action.php" => self::mustache_render('routes-action.mustache', $data),
			"$plugin_dir/$plugin_namespace/Setup.php" => self::mustache_render('setup.mustache', $data),
			"$plugin_dir/$plugin_slug.php" => self::mustache_render('plugin.mustache', $data),
			"$plugin_dir/config/features.php" => self::mustache_render('config-features.mustache', $data),
			"$plugin_dir/config/hooks.php" => self::mustache_render('config-hooks.mustache', $data),
			"$plugin_dir/config/providers.php" => self::mustache_render('config-providers.mustache', $data),
			"$plugin_dir/.gitignore" => self::mustache_render('gitignore.mustache', $data),
			"$plugin_dir/autoload.php" => self::mustache_render('autoload.mustache', $data),
			"$plugin_dir/bootstrap.php" => self::mustache_render('bootstrap.mustache', $data),
			"$plugin_dir/env.php" => self::mustache_render('env.mustache', $data),
			"$plugin_dir/helpers.php" => self::mustache_render('helpers.mustache', $data),
		), $force);

		WP_CLI::success("Le plugin a bien été créé. Let's go");
	}

	/**
	 * Localizes the template path.
	 */
	private static function mustache_render($template, $data = array())
	{
		return \WP_CLI\Utils\mustache_render(dirname(dirname(__FILE__)) . '/templates/' . $template, $data);
	}
}
