<?php

namespace Command;

class Section extends YakPress
{
	public static function create($args, $assoc_args, $dir_slug, $dir_path)
	{
		$section       = strtolower($args[0]);
		$section_class = ucwords(str_replace('-', '', $section));
		$dir_name      = ucwords(str_replace('-', ' ', $dir_slug));
		$dir_namespace = str_replace(' ', '', $dir_name);

		$data = [
			'section'       => $section,
			'section_class' => $section_class,
			'dir_namespace' => $dir_namespace
		];

		$force = \WP_CLI\Utils\get_flag_value($assoc_args, 'force');

		if (!is_dir("$dir_path/$dir_namespace/Features/Sections")) {
			\WP_CLI::success("Création du Dossier Sections");
			wp_mkdir_p("$dir_path/$dir_namespace/Features/Sections");
		}

		if (!is_file("$dir_path/$dir_namespace/Features/Sections/{$section_class}Section.php")) {
			// AJout du fichier pour le post type
			\WP_CLI::success("Création du fichier {$section_class}Section.php");

			$parent = new parent();
			$parent->create_files(array(
				"$dir_path/$dir_namespace/Features/Sections/{$section_class}Section.php" => self::mustache_render('commun/features-section.mustache', $data),
			), $force);

			// Ajout du use du namespace
			self::insert_into_file(
				"$dir_path/config/features.php",
				"<?php",
				"use $dir_namespace\\Features\\Sections\\{$section_class}Section;"
			);

			// Ajout dans le fichier config/features.php
			self::insert_into_file(
				"$dir_path/config/features.php",
				"### SECTIONS ###",
				"	['admin_init',[{$section_class}Section::class,'init']],"
			);


			\WP_CLI::success("Le section a bien été créé");
		} else {
			\WP_CLI::warning("Le fichier {$section_class}Section.php existe déjà");
		}
	}
}
