<?php

namespace Command;

class Taxonomy extends YakPress
{
	public static function create($args, $assoc_args, $dir_slug, $dir_path)
	{
		$taxonomy       = strtolower($args[0]);
		$taxonomy_class = ucwords(str_replace('-', '', $taxonomy));
		$dir_name       = ucwords(str_replace('-', ' ', $dir_slug));
		$dir_namespace  = str_replace(' ', '', $dir_name);

		$data = [
			'taxonomy'       => $taxonomy,
			'taxonomy_class' => $taxonomy_class,
			'dir_namespace'  => $dir_namespace
		];

		$force = \WP_CLI\Utils\get_flag_value($assoc_args, 'force');

		if (!is_dir("$dir_path/$dir_namespace/Features/Taxonomies")) {
			\WP_CLI::success("Création du Dossier Taxonomies");
			wp_mkdir_p("$dir_path/$dir_namespace/Features/Taxonomies");
		}

		if (!is_file("$dir_path/$dir_namespace/Features/Taxonomies/{$taxonomy_class}Taxonomy.php")) {
			// AJout du fichier pour le post type
			\WP_CLI::success("Création du fichier {$taxonomy_class}Taxonomy.php");

			$parent = new parent();
			$parent->create_files(array(
				"$dir_path/$dir_namespace/Features/Taxonomies/{$taxonomy_class}Taxonomy.php" => self::mustache_render('commun/features-taxonomy.mustache', $data),
			), $force);

			// Ajout du use du namespace
			self::insert_into_file(
				"$dir_path/config/features.php",
				"<?php",
				"use $dir_namespace\\Features\\Taxonomies\\{$taxonomy_class}Taxonomy;"
			);

			// Ajout dans le fichier config/features.php
			self::insert_into_file(
				"$dir_path/config/features.php",
				"### TAXONOMIES ###",
				"	['init',[{$taxonomy_class}Taxonomy::class,'register']],"
			);


			\WP_CLI::success("Le taxonomy a bien été créé");
		} else {
			\WP_CLI::warning("Le fichier {$taxonomy_class}Taxonomy.php existe déjà");
		}
	}
}
