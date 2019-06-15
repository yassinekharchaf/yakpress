<?php

namespace Command;

class Customizer extends YakPress
{
	public static function create($args, $assoc_args, $dir_slug, $dir_path)
	{
		$customizer       = strtolower($args[0]);
		$customizer_class = ucwords(str_replace('-', '', $customizer));
		$dir_name        = ucwords(str_replace('-', ' ', $dir_slug));
		$dir_namespace   = str_replace(' ', '', $dir_name);

		$data = [
			'customizer'       => $customizer,
			'customizer_class' => $customizer_class,
			'dir_namespace'   => $dir_namespace
		];

		$force = \WP_CLI\Utils\get_flag_value($assoc_args, 'force');

		if (!is_dir("$dir_path/$dir_namespace/Features/Customizers")) {
			\WP_CLI::success("Création du Dossier Customizers");
			wp_mkdir_p("$dir_path/$dir_namespace/Features/Customizers");
		}

		if (!is_file("$dir_path/$dir_namespace/Features/Customizers/{$customizer_class}Customizer.php")) {
			// AJout du fichier pour le post type
			\WP_CLI::success("Création du fichier {$customizer_class}Customizer.php");

			$parent = new parent();
			$parent->create_files(array(
				"$dir_path/$dir_namespace/Features/Customizers/{$customizer_class}Customizer.php" => self::mustache_render('theme/features-customizers.mustache', $data),
			), $force);

			// Ajout du use du namespace
			self::insert_into_file(
				"$dir_path/config/features.php",
				"<?php",
				"use $dir_namespace\\Features\\Customizers\\{$customizer_class}Customizer;"
			);

			// Ajout dans le fichier config/features.php
			self::insert_into_file(
				"$dir_path/config/features.php",
				"### CUSTOMIZERS ###",
				"	['customize_register',[{$customizer_class}Customizer::class,'register']],"
			);


			\WP_CLI::success("Le customizer a bien été créé");
		} else {
			\WP_CLI::warning("Le fichier {$customizer_class}Customizer.php existe déjà");
		}
	}
}
