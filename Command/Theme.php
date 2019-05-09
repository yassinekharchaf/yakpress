<?php

namespace Command;


class Theme extends YakPress
{
	public static function create($args, $assoc_args)
	{
		$theme_slug      = $args[0];
		$theme_name      = ucwords(str_replace('-', ' ', $theme_slug));
		$theme_namespace = str_replace(' ', '', $theme_name);


		$data = wp_parse_args($assoc_args, array(
			'theme_slug'       => $theme_slug,
			'theme_namespace'  => $theme_namespace,
			'dir_namespace'    => $theme_namespace,
			'theme_name'       => $theme_name,
			'textdomain'       => $theme_slug,
			'theme_prefix'     => strtoupper(substr($theme_slug, 0, 3)),
			'helper_namespace' => "Theme\\"
		));

		$theme_dir = get_theme_root() . "/$theme_slug";
		$force     = \WP_CLI\Utils\get_flag_value($assoc_args, 'force');

		if (is_dir($theme_dir)) {
			\WP_CLI::halt("Ce thème existe déjà.");
		}

		wp_mkdir_p("$theme_dir/$theme_namespace");
		wp_mkdir_p("$theme_dir/$theme_namespace/Features");
		wp_mkdir_p("$theme_dir/$theme_namespace/Http");
		wp_mkdir_p("$theme_dir/$theme_namespace/Http/Requests");
		wp_mkdir_p("$theme_dir/config");
		wp_mkdir_p("$theme_dir/resources");
		wp_mkdir_p("$theme_dir/resources/assets");
		wp_mkdir_p("$theme_dir/resources/assets/js");
		wp_mkdir_p("$theme_dir/resources/assets/css");
		wp_mkdir_p("$theme_dir/resources/views");
		wp_mkdir_p("$theme_dir/resources/src");
		wp_mkdir_p("$theme_dir/resources/src/js");
		wp_mkdir_p("$theme_dir/resources/src/sass");
		wp_mkdir_p("$theme_dir/routes");

		$parent = new parent();

		$file_to_create = array(
			"$theme_dir/routes/action.php"                                 => self::mustache_render('commun/routes-action.mustache', $data),
			"$theme_dir/$theme_namespace/Providers/ServicesProvider.php"   => self::mustache_render('commun/providers-services.mustache', $data),
			"$theme_dir/$theme_namespace/Providers/RoutesProvider.php"     => self::mustache_render('theme/providers-routes.mustache', $data),
			"$theme_dir/$theme_namespace/Providers/HooksProvider.php"      => self::mustache_render('commun/providers-hooks.mustache', $data),
			"$theme_dir/$theme_namespace/Providers/FeaturesProvider.php"   => self::mustache_render('commun/providers-features.mustache', $data),
			"$theme_dir/$theme_namespace/Providers/ImageSizesProvider.php" => self::mustache_render('theme/providers-image-size.mustache', $data),
			"$theme_dir/$theme_namespace/Providers/MenusProvider.php"      => self::mustache_render('theme/providers-menus.mustache', $data),
			"$theme_dir/$theme_namespace/Providers/SupportsProvider.php"   => self::mustache_render('theme/providers-supports.mustache', $data),
			"$theme_dir/$theme_namespace/Http/Requests/Validate.php"       => self::mustache_render('commun/http-request-validate.mustache', $data),
			"$theme_dir/functions.php"                                     => self::mustache_render('theme/functions.mustache', $data),
			"$theme_dir/style.css"                                         => self::mustache_render('theme/style.mustache', $data),
			"$theme_dir/config/features.php"                               => self::mustache_render('commun/config-features.mustache', $data),
			"$theme_dir/config/hooks.php"                                  => self::mustache_render('commun/config-hooks.mustache', $data),
			"$theme_dir/config/providers.php"                              => self::mustache_render('theme/config-providers.mustache', $data),
			"$theme_dir/config/image-size.php"                             => self::mustache_render('theme/config-image-size.mustache', $data),
			"$theme_dir/config/menus.php"                                  => self::mustache_render('theme/config-menus.mustache', $data),
			"$theme_dir/config/supports.php"                               => self::mustache_render('theme/config-supports.mustache', $data),
			"$theme_dir/config/twig.php"                                   => self::mustache_render('theme/config-twig.mustache', $data),
			"$theme_dir/config/twig-env.php"                               => self::mustache_render('theme/config-twig-env.mustache', $data),
			"$theme_dir/.gitignore"                                        => self::mustache_render('theme/gitignore.mustache', $data),
			"$theme_dir/composer.json"                                     => self::mustache_render('theme/composer.mustache', $data),
			"$theme_dir/bootstrap.php"                                     => self::mustache_render('theme/bootstrap.mustache', $data),
			"$theme_dir/env.php"                                           => self::mustache_render('theme/env.mustache', $data),
			"$theme_dir/helpers.php"                                       => self::mustache_render('theme/helpers.mustache', $data),
			"$theme_dir/index.php"                                         => self::mustache_render('theme/index.mustache', $data),
			"$theme_dir/resources/views/index.twig"                        => self::mustache_render('theme/views-index.mustache', $data),
		);


		$files_written = $parent->create_files($file_to_create, $force);

		$parent->log_whether_files_written(
			$files_written,
			$skip_message    = 'All theme files were skipped.',
			$success_message = 'Created theme files.'
		);

		shell_exec("composer install -d $theme_dir");

		\WP_CLI::success("Le theme a bien été créé. Let's go");
	}
}
