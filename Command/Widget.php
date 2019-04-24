<?php

namespace Command;

class Widget extends YakPress
{
	public static function create($args, $assoc_args, $dir_slug, $dir_path)
	{
		$widget        = strtolower($args[0]);
		$widget_class  = ucwords(str_replace('-', '', $widget));
		$dir_name      = ucwords(str_replace('-', ' ', $dir_slug));
		$dir_namespace = str_replace(' ', '', $dir_name);

		$data = [
			'widget'        => $widget,
			'widget_class'  => $widget_class,
			'dir_namespace' => $dir_namespace
		];

		$force = \WP_CLI\Utils\get_flag_value($assoc_args, 'force');

		if (!is_dir("$dir_path/$dir_namespace/Features/Widgets")) {
			\WP_CLI::success("Création du Dossier Widgets");
			wp_mkdir_p("$dir_path/$dir_namespace/Features/Widgets");
		}

		if (!is_file("$dir_path/$dir_namespace/Features/Widgets/{$widget_class}Widget.php")) {
			// AJout du fichier pour le post type
			\WP_CLI::success("Création du fichier {$widget_class}Widget.php");

			$parent = new parent();
			$parent->create_files(array(
				"$dir_path/$dir_namespace/Features/Widgets/{$widget_class}Widget.php" => self::mustache_render('commun/features-widget.mustache', $data),
			), $force);

			// Ajout du use du namespace
			self::insert_into_file(
				"$dir_path/config/features.php",
				"<?php",
				"use $dir_namespace\\Features\\Widgets\\{$widget_class}Widget;"
			);

			// Ajout dans le fichier config/features.php
			self::insert_into_file(
				"$dir_path/config/features.php",
				"### WIDGETS ###",
				"	['widget_init',[{$widget_class}Widget::class,'register']],"
			);


			\WP_CLI::success("Le widget a bien été créé");
		} else {
			\WP_CLI::warning("Le fichier {$widget_class}Widget.php existe déjà");
		}
	}
}
