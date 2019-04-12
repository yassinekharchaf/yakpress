<?php

class Controller extends YakPress
{
	public static function create($args, $assoc_args)
	{
		$controller = strtolower($args[0]);
		$controller_class = ucwords(str_replace('-', '', $controller));
		$plugin_name = $assoc_args['plugin'];
		$plugin_namespace = ucfirst($plugin_name);
		$plugin_dir = WP_PLUGIN_DIR . "/$plugin_name";
		$force = \WP_CLI\Utils\get_flag_value($assoc_args, 'force');
		$model = \WP_CLI\Utils\get_flag_value($assoc_args, 'model');

		$data = [
			'controller' => $controller,
			'controller_class' => $controller_class,
			'plugin_namespace' => $plugin_namespace,
			'model'            => $model
		];


		if (!is_dir("$plugin_dir/$plugin_namespace/Http/Controllers")) {
			WP_CLI::success("Création du Dossier Controllers");
			wp_mkdir_p("$plugin_dir/$plugin_namespace/Http/Controllers");
		}

		if (!is_file("$plugin_dir/$plugin_namespace/Http/Controllers/{$controller_class}Controller.php")) {
			// AJout du fichier pour le post type

			$parent = new parent();
			$parent->create_files(array(
				"$plugin_dir/$plugin_namespace/Http/Controllers/{$controller_class}Controller.php" => self::mustache_render('http-controller.mustache', $data),
			), $force);

			WP_CLI::success("Création du fichier {$controller_class}Controller.php");


			if ($model) {
				if (!is_file("$plugin_dir/$plugin_namespace/Http/Models/Model.php")) {
					// AJout du fichier pour le post type

					$parent = new parent();
					$parent->create_files(array(
						"$plugin_dir/$plugin_namespace/Http/Models/Model.php" => self::mustache_render('http-model-main.mustache', $data),
					), $force);
					WP_CLI::success("Création du fichier Model.php");
				}
				$parent->create_files(array(
					"$plugin_dir/$plugin_namespace/Http/Models/{$controller_class}Model.php" => self::mustache_render('http-model.mustache', $data),
				), $force);
				WP_CLI::success("Création du fichier {$controller_class}Model.php");
			}


			WP_CLI::success("Le controller a bien été créé");
		} else {
			WP_CLI::warning("Le fichier {$controller_class}Controller.php existe déjà");
		}
	}
}
