<?php

class Plugin extends YakPress
{
	public static function create($args, $assoc_args)
	{
		$plugin_slug    = $args[0];
		$plugin_name    = ucwords(str_replace('-', ' ', $plugin_slug));
		$plugin_namespace = str_replace(' ', '', $plugin_name);
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
		$nohelpers = \WP_CLI\Utils\get_flag_value($assoc_args, 'nohelpers');

		wp_mkdir_p("$plugin_dir/$plugin_namespace");
		wp_mkdir_p("$plugin_dir/$plugin_namespace/Databases");
		wp_mkdir_p("$plugin_dir/$plugin_namespace/Databases/Migrations");
		wp_mkdir_p("$plugin_dir/$plugin_namespace/Features");
		wp_mkdir_p("$plugin_dir/$plugin_namespace/Http");
		wp_mkdir_p("$plugin_dir/$plugin_namespace/Http/Requests");
		wp_mkdir_p("$plugin_dir/config");
		wp_mkdir_p("$plugin_dir/resources");
		wp_mkdir_p("$plugin_dir/resources/assets");
		wp_mkdir_p("$plugin_dir/resources/views");
		wp_mkdir_p("$plugin_dir/routes");

		$parent = new parent();

		$file_to_create = array(
			"$plugin_dir/$plugin_namespace/Databases/Database.php" => self::mustache_render('databases-database.mustache', $data),
			"$plugin_dir/routes/action.php" => self::mustache_render('routes-action.mustache', $data),
			"$plugin_dir/$plugin_namespace/Setup.php" => self::mustache_render('setup.mustache', $data),
			"$plugin_dir/$plugin_namespace/Providers/ServicesProvider.php" => self::mustache_render('setup.mustache', $data),
			"$plugin_dir/$plugin_namespace/Providers/RoutesProvider.php" => self::mustache_render('setup.mustache', $data),
			"$plugin_dir/$plugin_namespace/Providers/HooksProvider.php" => self::mustache_render('setup.mustache', $data),
			"$plugin_dir/$plugin_namespace/Providers/FeaturesProvider.php" => self::mustache_render('setup.mustache', $data),
			"$plugin_dir/$plugin_namespace/Http/Requests/Validate.php" => self::mustache_render('http-request-validate.mustache', $data),
			"$plugin_dir/$plugin_slug.php" => self::mustache_render('plugin.mustache', $data),
			"$plugin_dir/config/features.php" => self::mustache_render('config-features.mustache', $data),
			"$plugin_dir/config/hooks.php" => self::mustache_render('config-hooks.mustache', $data),
			"$plugin_dir/config/providers.php" => self::mustache_render('config-providers.mustache', $data),
			"$plugin_dir/.gitignore" => self::mustache_render('gitignore.mustache', $data),
			"$plugin_dir/autoload.php" => self::mustache_render('autoload.mustache', $data),
			"$plugin_dir/bootstrap.php" => self::mustache_render('bootstrap.mustache', $data),
			"$plugin_dir/env.php" => self::mustache_render('env.mustache', $data),
		);

		if (!$nohelpers) {
			$file_to_create["$plugin_dir/helpers.php"] = self::mustache_render('helpers.mustache', $data);
		}
		$files_written = $parent->create_files($file_to_create, $force);

		$parent->log_whether_files_written(
			$files_written,
			$skip_message = 'All plugin files were skipped.',
			$success_message = 'Created plugin files.'
		);

		WP_CLI::success("Le plugin a bien été créé. Let's go");
	}
}
