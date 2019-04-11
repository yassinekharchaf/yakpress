<?php

class Taxonomy extends YakPress
{
	public static function create($args, $assoc_args)
	{
		$taxonomy = strtolower($args[0]);
		$taxonomy_class = ucwords(str_replace('-', '', $taxonomy));
		$plugin_name = $assoc_args['plugin'];
		$plugin_namespace = ucfirst($plugin_name);
		$plugin_dir = WP_PLUGIN_DIR . "/$plugin_name";

		$data = [
			'taxonomy' => $taxonomy,
			'taxonomy_class' => $taxonomy_class,
			'plugin_namespace' => $plugin_namespace
		];

		$force = \WP_CLI\Utils\get_flag_value($assoc_args, 'force');

		if (!is_dir("$plugin_dir/$plugin_namespace/Features/Taxonomies")) {
			WP_CLI::success("Création du Dossier Taxonomies");
			wp_mkdir_p("$plugin_dir/$plugin_namespace/Features/Taxonomies");
		}

		if (!is_file("$plugin_dir/$plugin_namespace/Features/Taxonomies/{$taxonomy_class}Taxonomy.php")) {
			// AJout du fichier pour le post type
			WP_CLI::success("Création du fichier {$taxonomy_class}Taxonomy.php");

			$parent = new parent();
			$parent->create_files(array(
				"$plugin_dir/$plugin_namespace/Features/Taxonomies/{$taxonomy_class}Taxonomy.php" => self::mustache_render('features-taxonomy.mustache', $data),
			), $force);

			// Ajout du use du namespace
			self::insert_into_file(
				"$plugin_dir/config/features.php",
				"<?php",
				"use $plugin_namespace\\Features\\Taxonomies\\{$taxonomy_class}Taxonomy;"
			);

			// Ajout dans le fichier config/features.php
			self::insert_into_file(
				"$plugin_dir/config/features.php",
				"### TAXONOMIES ###",
				"	['init',[{$taxonomy_class}Taxonomy::class,'register']],"
			);


			WP_CLI::success("Le taxonomy a bien été créé");
		} else {
			WP_CLI::warning("Le fichier {$taxonomy_class}Taxonomy.php existe déjà");
		}
	}
}
