<?php

namespace Command;

class Model extends YakPress
{
	public static function create($args, $assoc_args, $dir_slug, $dir_path)
	{
		$model         = strtolower($args[0]);
		$model_class   = ucwords(str_replace('-', '', $model));
		$dir_name      = ucwords(str_replace('-', ' ', $dir_slug));
		$dir_namespace = str_replace(' ', '', $dir_name);
		$force         = \WP_CLI\Utils\get_flag_value($assoc_args, 'force');
		$controller    = \WP_CLI\Utils\get_flag_value($assoc_args, 'controller');

		$data = [
			'model'            => $model,
			'model_class'      => $model_class,
			'dir_namespace'    => $dir_namespace,
			'controller_class' => $model_class,
		];


		if (!is_dir("$dir_path/$dir_namespace/Http/Models")) {
			\WP_CLI::success("Création du Dossier Models");
			wp_mkdir_p("$dir_path/$dir_namespace/Http/Models");
		}

		if (!is_file("$dir_path/$dir_namespace/Http/Models/{$model_class}Model.php")) {
			// AJout du fichier pour le post type
			\WP_CLI::success("Création du fichier {$model_class}Model.php");

			$parent = new parent();
			$parent->create_files(array(
				"$dir_path/$dir_namespace/Http/Models/{$model_class}Model.php" => self::mustache_render('commun/http-model.mustache', $data),
			), $force);

			if (!is_file("$dir_path/$dir_namespace/Http/Models/Model.php")) {
				// AJout du fichier pour le post type

				$parent = new parent();
				$parent->create_files(array(
					"$dir_path/$dir_namespace/Http/Models/Model.php" => self::mustache_render('commun/http-model-main.mustache', $data),
				), $force);
				\WP_CLI::success("Création du fichier Model.php");
			}

			if ($controller) {
				$parent->create_files(array(
					"$dir_path/$dir_namespace/Http/Controllers/{$model_class}Controller.php" => self::mustache_render('commun/http-controller.mustache', $data),
				), $force);
				\WP_CLI::success("Création du fichier {$model_class}Controller.php");
			}


			\WP_CLI::success("Le model a bien été créé");
		} else {
			\WP_CLI::warning("Le fichier {$model_class}Model.php existe déjà");
		}
	}
}
