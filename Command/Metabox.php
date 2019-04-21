<?php

namespace Command;

class Metabox extends YakPress
{
	public static function create($args, $assoc_args)
	{
		$metabox = strtolower($args[0]);
		$metabox_class = ucwords(str_replace('-', '', $metabox));
		$plugin_slug    = self::get_plugin_slug($assoc_args);
		$plugin_name    = ucwords(str_replace('-', ' ', $plugin_slug));
		$plugin_namespace = str_replace(' ', '', $plugin_name);
		$plugin_dir = WP_PLUGIN_DIR . "/$plugin_slug";

		$data = [
			'metabox' => $metabox,
			'metabox_class' => $metabox_class,
			'plugin_namespace' => $plugin_namespace
		];

		$force = \WP_CLI\Utils\get_flag_value($assoc_args, 'force');

		if (!is_dir("$plugin_dir/$plugin_namespace/Features/MetaBoxes")) {
			\WP_CLI::success("Création du Dossier MetaBoxes");
			wp_mkdir_p("$plugin_dir/$plugin_namespace/Features/MetaBoxes");
		}

		if (!is_file("$plugin_dir/$plugin_namespace/Features/MetaBoxes/{$metabox_class}MetaBox.php")) {
			// AJout du fichier pour le post type
			\WP_CLI::success("Création du fichier {$metabox_class}MetaBox.php");

			$parent = new parent();
			$parent->create_files(array(
				"$plugin_dir/$plugin_namespace/Features/MetaBoxes/{$metabox_class}MetaBox.php" => self::mustache_render('plugin/features-metabox.mustache', $data),
			), $force);

			// Ajout du use du namespace
			self::insert_into_file(
				"$plugin_dir/config/features.php",
				"<?php",
				"use $plugin_namespace\\Features\\MetaBoxes\\{$metabox_class}Metabox;"
			);

			// Ajout dans le fichier config/features.php
			self::insert_into_file(
				"$plugin_dir/config/features.php",
				"### METABOXES ###",
				"	['add_meta_boxes',[{$metabox_class}Metabox::class,'init']],"
			);

			\WP_CLI::success("La metabox a bien été créé");
		} else {
			\WP_CLI::warning("Le fichier {$metabox_class}MetaBox.php existe déjà");
		}
	}
}
