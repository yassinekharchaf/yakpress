<?php

namespace Command;

class Middleware extends YakPress
{
	public static function create($args, $assoc_args, $dir_slug, $dir_path)
	{
		$middleware       = strtolower($args[0]);
		$middleware_class = ucwords(str_replace('-', '', $middleware));
		$dir_name         = ucwords(str_replace('-', ' ', $dir_slug));
		$dir_namespace    = str_replace(' ', '', $dir_name);
		$force            = \WP_CLI\Utils\get_flag_value($assoc_args, 'force');

		$data = [
			'middleware'       => $middleware,
			'middleware_class' => $middleware_class,
			'dir_namespace'    => $dir_namespace,
		];


		if (!is_dir("$dir_path/$dir_namespace/Http/Middlewares")) {
			\WP_CLI::success("Création du Dossier Middlewares");
			wp_mkdir_p("$dir_path/$dir_namespace/Http/Middlewares");
		}

		if (!is_file("$dir_path/$dir_namespace/Http/Middlewares/{$middleware_class}Middleware.php")) {
			// AJout du fichier pour le post type
			\WP_CLI::success("Création du fichier {$middleware_class}Middleware.php");

			$parent = new parent();
			$parent->create_files(array(
				"$dir_path/$dir_namespace/Http/Middlewares/{$middleware_class}Middleware.php" => self::mustache_render('commun/http-middleware.mustache', $data),
			), $force);


			\WP_CLI::success("Le middleware a bien été créé");
		} else {
			\WP_CLI::warning("Le fichier {$middleware_class}Middleware.php existe déjà");
		}
	}
}
