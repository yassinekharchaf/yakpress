<?php

class Section extends YakPress
{
	public static function create($args, $assoc_args)
	{
		$section = strtolower($args[0]);
		$section_class = ucwords(str_replace('-', '', $section));
		$plugin_name = $assoc_args['plugin'];
		$plugin_namespace = ucfirst($plugin_name);
		$plugin_dir = WP_PLUGIN_DIR . "/$plugin_name";

		$data = [
			'section' => $section,
			'section_class' => $section_class,
			'plugin_namespace' => $plugin_namespace
		];

		$force = \WP_CLI\Utils\get_flag_value($assoc_args, 'force');

		if (!is_dir("$plugin_dir/$plugin_namespace/Features/Sections")) {
			WP_CLI::success("Création du Dossier Sections");
			wp_mkdir_p("$plugin_dir/$plugin_namespace/Features/Sections");
		}

		if (!is_file("$plugin_dir/$plugin_namespace/Features/Sections/{$section_class}Section.php")) {
			// AJout du fichier pour le post type
			WP_CLI::success("Création du fichier {$section_class}Section.php");

			$parent = new parent();
			$parent->create_files(array(
				"$plugin_dir/$plugin_namespace/Features/Sections/{$section_class}Section.php" => self::mustache_render('features-section.mustache', $data),
			), $force);

			// Ajout du use du namespace
			self::insert_into_file(
				"$plugin_dir/config/features.php",
				"<?php",
				"use $plugin_namespace\\Features\\Sections\\{$section_class}Section;"
			);

			// Ajout dans le fichier config/features.php
			self::insert_into_file(
				"$plugin_dir/config/features.php",
				"### SECTIONS ###",
				"	['admin_init',[{$section_class}Section::class,'init']],"
			);


			WP_CLI::success("Le section a bien été créé");
		} else {
			WP_CLI::warning("Le fichier {$section_class}Section.php existe déjà");
		}
	}
}
