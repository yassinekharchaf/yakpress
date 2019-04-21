<?php

namespace Command;

class Widget extends YakPress
{
	public static function create($args, $assoc_args)
	{
		$widget = strtolower($args[0]);
		$widget_class = ucwords(str_replace('-', '', $widget));
		$plugin_slug    = self::get_plugin_slug($assoc_args);
		$plugin_name    = ucwords(str_replace('-', ' ', $plugin_slug));
		$plugin_namespace = str_replace(' ', '', $plugin_name);
		$plugin_dir = WP_PLUGIN_DIR . "/$plugin_slug";

		$data = [
			'widget' => $widget,
			'widget_class' => $widget_class,
			'plugin_namespace' => $plugin_namespace
		];

		$force = \WP_CLI\Utils\get_flag_value($assoc_args, 'force');

		if (!is_dir("$plugin_dir/$plugin_namespace/Features/Widgets")) {
			\WP_CLI::success("Création du Dossier Widgets");
			wp_mkdir_p("$plugin_dir/$plugin_namespace/Features/Widgets");
		}

		if (!is_file("$plugin_dir/$plugin_namespace/Features/Widgets/{$widget_class}Widget.php")) {
			// AJout du fichier pour le post type
			\WP_CLI::success("Création du fichier {$widget_class}Widget.php");

			$parent = new parent();
			$parent->create_files(array(
				"$plugin_dir/$plugin_namespace/Features/Widgets/{$widget_class}Widget.php" => self::mustache_render('plugin/features-widget.mustache', $data),
			), $force);

			// Ajout du use du namespace
			self::insert_into_file(
				"$plugin_dir/config/features.php",
				"<?php",
				"use $plugin_namespace\\Features\\Widgets\\{$widget_class}Widget;"
			);

			// Ajout dans le fichier config/features.php
			self::insert_into_file(
				"$plugin_dir/config/features.php",
				"### WIDGETS ###",
				"	['widget_init',[{$widget_class}Widget::class,'register']],"
			);


			\WP_CLI::success("Le widget a bien été créé");
		} else {
			\WP_CLI::warning("Le fichier {$widget_class}Widget.php existe déjà");
		}
	}
}
