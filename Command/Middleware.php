<?php

class Middleware extends YakPress
{
	public static function create($args, $assoc_args)
	{
		$middleware = strtolower($args[0]);
		$middleware_class = ucwords(str_replace('-', '', $middleware));
		$plugin_slug    = $assoc_args['plugin'];
		$plugin_name    = ucwords(str_replace('-', ' ', $plugin_slug));
		$plugin_namespace = str_replace(' ', '', $plugin_name);
		$plugin_dir = WP_PLUGIN_DIR . "/$plugin_slug";
		$force = \WP_CLI\Utils\get_flag_value($assoc_args, 'force');

		$data = [
			'middleware' => $middleware,
			'middleware_class' => $middleware_class,
			'plugin_namespace' => $plugin_namespace,
		];


		if (!is_dir("$plugin_dir/$plugin_namespace/Http/Middlewares")) {
			WP_CLI::success("Création du Dossier Middlewares");
			wp_mkdir_p("$plugin_dir/$plugin_namespace/Http/Middlewares");
		}

		if (!is_file("$plugin_dir/$plugin_namespace/Http/Middlewares/{$middleware_class}Middleware.php")) {
			// AJout du fichier pour le post type
			WP_CLI::success("Création du fichier {$middleware_class}Middleware.php");

			$parent = new parent();
			$parent->create_files(array(
				"$plugin_dir/$plugin_namespace/Http/Middlewares/{$middleware_class}Middleware.php" => self::mustache_render('http-middleware.mustache', $data),
			), $force);


			WP_CLI::success("Le middleware a bien été créé");
		} else {
			WP_CLI::warning("Le fichier {$middleware_class}Middleware.php existe déjà");
		}
	}
}
