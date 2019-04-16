<?php

class Model extends YakPress
{
	public static function create($args, $assoc_args)
	{
		$model = strtolower($args[0]);
		$model_class = ucwords(str_replace('-', '', $model));
		$plugin_slug    = $assoc_args['plugin'];
		$plugin_name    = ucwords(str_replace('-', ' ', $plugin_slug));
		$plugin_namespace = str_replace(' ', '', $plugin_name);
		$plugin_dir = WP_PLUGIN_DIR . "/$plugin_slug";
		$force = \WP_CLI\Utils\get_flag_value($assoc_args, 'force');
		$controller = \WP_CLI\Utils\get_flag_value($assoc_args, 'controller');

		$data = [
			'model' => $model,
			'model_class' => $model_class,
			'plugin_namespace' => $plugin_namespace,
			'controller_class' => $model_class,
		];


		if (!is_dir("$plugin_dir/$plugin_namespace/Http/Models")) {
			WP_CLI::success("Création du Dossier Models");
			wp_mkdir_p("$plugin_dir/$plugin_namespace/Http/Models");
		}

		if (!is_file("$plugin_dir/$plugin_namespace/Http/Models/{$model_class}Model.php")) {
			// AJout du fichier pour le post type
			WP_CLI::success("Création du fichier {$model_class}Model.php");

			$parent = new parent();
			$parent->create_files(array(
				"$plugin_dir/$plugin_namespace/Http/Models/{$model_class}Model.php" => self::mustache_render('http-model.mustache', $data),
			), $force);

			if (!is_file("$plugin_dir/$plugin_namespace/Http/Models/Model.php")) {
				// AJout du fichier pour le post type

				$parent = new parent();
				$parent->create_files(array(
					"$plugin_dir/$plugin_namespace/Http/Models/Model.php" => self::mustache_render('http-model-main.mustache', $data),
				), $force);
				WP_CLI::success("Création du fichier Model.php");
			}

			if ($controller) {
				$parent->create_files(array(
					"$plugin_dir/$plugin_namespace/Http/Controllers/{$model_class}Controller.php" => self::mustache_render('http-controller.mustache', $data),
				), $force);
				WP_CLI::success("Création du fichier {$model_class}Controller.php");
			}


			WP_CLI::success("Le model a bien été créé");
		} else {
			WP_CLI::warning("Le fichier {$model_class}Model.php existe déjà");
		}
	}
}
