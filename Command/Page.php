<?php

class Page extends YakPress
{
	public static function create($args, $assoc_args)
	{
		$page = strtolower($args[0]);
		$page_class = ucwords(str_replace('-', '', $page));
		$controller_class = $page_class;
		$model_class = $page_class;
		$plugin_name = $assoc_args['plugin'];
		$plugin_namespace = ucfirst($plugin_name);
		$plugin_dir = WP_PLUGIN_DIR . "/$plugin_name";

		$controller = \WP_CLI\Utils\get_flag_value($assoc_args, 'controller');
		$model = \WP_CLI\Utils\get_flag_value($assoc_args, 'model');
		$force = \WP_CLI\Utils\get_flag_value($assoc_args, 'force');

		$data = [
			'page' => $page,
			'page_class' => $page_class,
			'plugin_namespace' => $plugin_namespace,
			'controller' => $controller,
			'controller_class' => $controller_class,
			'model' => $model,
			'model_class' => $model_class,
		];



		if (!is_dir("$plugin_dir/$plugin_namespace/Features/Pages")) {
			WP_CLI::success("Création du Dossier Pages");
			wp_mkdir_p("$plugin_dir/$plugin_namespace/Features/Pages");
		}

		if (!is_file("$plugin_dir/$plugin_namespace/Features/Pages/{$page_class}Page.php")) {
			// AJout du fichier pour le post type
			WP_CLI::success("Création du fichier {$page_class}Page.php");

			$parent = new parent();
			$parent->create_files(array(
				"$plugin_dir/$plugin_namespace/Features/Pages/{$page_class}Page.php" => self::mustache_render('features-page.mustache', $data),
			), $force);

			// Ajout du use du namespace
			self::insert_into_file(
				"$plugin_dir/config/features.php",
				"<?php",
				"use $plugin_namespace\\Features\\Pages\\{$page_class}Page;"
			);

			// Ajout dans le fichier config/features.php
			self::insert_into_file(
				"$plugin_dir/config/features.php",
				"### PAGES ###",
				"	['admin_menu',[{$page_class}Page::class,'init']],"
			);

			if ($controller) {
				if (!is_dir("$plugin_dir/$plugin_namespace/Http/Controllers")) {
					WP_CLI::success("Création du Dossier Controllers");
					wp_mkdir_p("$plugin_dir/$plugin_namespace/Http/Controllers");
				}
				$parent->create_files(array(
					"$plugin_dir/$plugin_namespace/Http/Controllers/{$page_class}Controller.php" => self::mustache_render('http-controller.mustache', $data),
				), $force);
			}

			if ($model) {
				if (!is_dir("$plugin_dir/$plugin_namespace/Http/Models")) {
					WP_CLI::success("Création du Dossier Models");
					wp_mkdir_p("$plugin_dir/$plugin_namespace/Http/Models");
				}

				if (!is_file("$plugin_dir/$plugin_namespace/Http/Models/Model.php")) {
					WP_CLI::success("Création du fichier de base Model.php");
					$parent->create_files(array(
						"$plugin_dir/$plugin_namespace/Http/Models/Model.php" => self::mustache_render('http-model-main.mustache', $data),
					), $force);
				}

				$parent->create_files(array(
					"$plugin_dir/$plugin_namespace/Http/Models/{$page_class}Model.php" => self::mustache_render('http-model.mustache', $data),
				), $force);
			}

			WP_CLI::success("Le page a bien été créé");
		} else {
			WP_CLI::warning("Le fichier {$page_class}Page.php existe déjà");
		}
	}
}
