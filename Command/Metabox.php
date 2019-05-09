<?php

namespace Command;

class Metabox extends YakPress
{
	public static function create($args, $assoc_args, $dir_slug, $dir_path)
	{
		$metabox       = strtolower($args[0]);
		$metabox_class = ucwords(str_replace('-', '', $metabox));
		$dir_name      = ucwords(str_replace('-', ' ', $dir_slug));
		$dir_namespace = str_replace(' ', '', $dir_name);

		$data = [
			'metabox'       => $metabox,
			'metabox_class' => $metabox_class,
			'dir_namespace' => $dir_namespace
		];

		$force = \WP_CLI\Utils\get_flag_value($assoc_args, 'force');

		if (!is_dir("$dir_path/$dir_namespace/Features/MetaBoxes")) {
			\WP_CLI::success("Création du Dossier MetaBoxes");
			wp_mkdir_p("$dir_path/$dir_namespace/Features/MetaBoxes");
		}

		if (!is_file("$dir_path/$dir_namespace/Features/MetaBoxes/{$metabox_class}MetaBox.php")) {
			// AJout du fichier pour le post type
			\WP_CLI::success("Création du fichier {$metabox_class}MetaBox.php");

			$parent = new parent();
			$parent->create_files(array(
				"$dir_path/$dir_namespace/Features/MetaBoxes/{$metabox_class}MetaBox.php" => self::mustache_render('commun/features-metabox.mustache', $data),
			), $force);

			// Ajout du use du namespace
			self::insert_into_file(
				"$dir_path/config/features.php",
				"<?php",
				"use $dir_namespace\\Features\\MetaBoxes\\{$metabox_class}MetaBox;"
			);

			// Ajout dans le fichier config/features.php
			self::insert_into_file(
				"$dir_path/config/features.php",
				"### METABOXES ###",
				"	['add_meta_boxes',[{$metabox_class}Metabox::class,'add_meta_box']],"
			);

			\WP_CLI::success("La metabox a bien été créé");
		} else {
			\WP_CLI::warning("Le fichier {$metabox_class}MetaBox.php existe déjà");
		}
	}
}
