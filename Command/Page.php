<?php

namespace Command;

class Page extends YakPress
{
	public static function create($args, $assoc_args, $dir_slug, $dir_path)
	{
		$page             = strtolower($args[0]);
		$page_class       = ucwords(str_replace('-', '', $page));
		$controller_class = $page_class;
		$model_class      = $page_class;
		$dir_name         = ucwords(str_replace('-', ' ', $dir_slug));
		$dir_namespace    = str_replace(' ', '', $dir_name);

		$controller = \WP_CLI\Utils\get_flag_value($assoc_args, 'controller');
		$model = \WP_CLI\Utils\get_flag_value($assoc_args, 'model');
		$force = \WP_CLI\Utils\get_flag_value($assoc_args, 'force');

		$data = [
			'page'             => $page,
			'page_class'       => $page_class,
			'dir_namespace'    => $dir_namespace,
			'controller'       => $controller,
			'controller_class' => $controller_class,
			'model'            => $model,
			'model_class'      => $model_class,
		];



		if (!is_dir("$dir_path/$dir_namespace/Features/Pages")) {
			\WP_CLI::success("Création du Dossier Pages");
			wp_mkdir_p("$dir_path/$dir_namespace/Features/Pages");
		}

		if (!is_file("$dir_path/$dir_namespace/Features/Pages/{$page_class}Page.php")) {
			// AJout du fichier pour le post type
			\WP_CLI::success("Création du fichier {$page_class}Page.php");

			$parent = new parent();
			$parent->create_files(array(
				"$dir_path/$dir_namespace/Features/Pages/{$page_class}Page.php" => self::mustache_render('commun/features-page.mustache', $data),
			), $force);

			// Ajout du use du namespace
			self::insert_into_file(
				"$dir_path/config/features.php",
				"<?php",
				"use $dir_namespace\\Features\\Pages\\{$page_class}Page;"
			);

			// Ajout dans le fichier config/features.php
			self::insert_into_file(
				"$dir_path/config/features.php",
				"### PAGES ###",
				"	['admin_menu',[{$page_class}Page::class,'init']],"
			);

			if ($controller) {
				if (!is_dir("$dir_path/$dir_namespace/Http/Controllers")) {
					\WP_CLI::success("Création du Dossier Controllers");
					wp_mkdir_p("$dir_path/$dir_namespace/Http/Controllers");
				}
				$parent->create_files(array(
					"$dir_path/$dir_namespace/Http/Controllers/{$page_class}Controller.php" => self::mustache_render('commun/http-controller.mustache', $data),
				), $force);
			}

			if ($model) {
				if (!is_dir("$dir_path/$dir_namespace/Http/Models")) {
					\WP_CLI::success("Création du Dossier Models");
					wp_mkdir_p("$dir_path/$dir_namespace/Http/Models");
				}

				if (!is_file("$dir_path/$dir_namespace/Http/Models/Model.php")) {
					\WP_CLI::success("Création du fichier de base Model.php");
					$parent->create_files(array(
						"$dir_path/$dir_namespace/Http/Models/Model.php" => self::mustache_render('dir/http-model-main.mustache', $data),
					), $force);
				}

				$parent->create_files(array(
					"$dir_path/$dir_namespace/Http/Models/{$page_class}Model.php" => self::mustache_render('dir/http-model.mustache', $data),
				), $force);
			}

			\WP_CLI::success("Le page a bien été créé");
		} else {
			\WP_CLI::warning("Le fichier {$page_class}Page.php existe déjà");
		}
	}
}
