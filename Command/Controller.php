<?php

namespace Command;

class Controller extends YakPress
{
	public static function create($args, $assoc_args, $dir_slug, $dir_path)
	{
		$controller       = strtolower($args[0]);
		$controller_class = ucwords(str_replace('-', '', $controller));
		$dir_name         = ucwords(str_replace('-', ' ', $dir_slug));
		$dir_namespace    = str_replace(' ', '', $dir_name);
		$force            = \WP_CLI\Utils\get_flag_value($assoc_args, 'force');
		$model            = \WP_CLI\Utils\get_flag_value($assoc_args, 'model');
		$resource         = \WP_CLI\Utils\get_flag_value($assoc_args, 'resource');

		$data = [
			'controller'       => $controller,
			'controller_class' => $controller_class,
			'dir_namespace'    => $dir_namespace,
			'model'            => $model,
			'resource'         => $resource
		];


		if (!is_dir("$dir_path/$dir_namespace/Http/Controllers")) {
			\WP_CLI::success("Création du Dossier Controllers");
			wp_mkdir_p("$dir_path/$dir_namespace/Http/Controllers");
		}

		if (!is_file("$dir_path/$dir_namespace/Http/Controllers/{$controller_class}Controller.php")) {
			// AJout du fichier pour le post type

			$parent = new parent();
			$parent->create_files(array(
				"$dir_path/$dir_namespace/Http/Controllers/{$controller_class}Controller.php" => self::mustache_render("commun/http-controller.mustache", $data),
			), $force);

			\WP_CLI::success("Création du fichier {$controller_class}Controller.php");


			if ($model) {
				if (!is_file("$dir_path/$dir_namespace/Http/Models/Model.php")) {
					// AJout du fichier pour le post type

					$parent = new parent();
					$parent->create_files(array(
						"$dir_path/$dir_namespace/Http/Models/Model.php" => self::mustache_render("commun/http-model-main.mustache", $data),
					), $force);
					\WP_CLI::success("Création du fichier Model.php");
				}
				$parent->create_files(array(
					"$dir_path/$dir_namespace/Http/Models/{$controller_class}Model.php" => self::mustache_render("commun/http-model.mustache", $data),
				), $force);
				\WP_CLI::success("Création du fichier {$controller_class}Model.php");
			}


			\WP_CLI::success("Le controller a bien été créé");
		} else {
			\WP_CLI::warning("Le fichier {$controller_class}Controller.php existe déjà");
		}
	}
}
