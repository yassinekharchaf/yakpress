<?php

class PostType extends YakPress
{
	public static function create($args, $assoc_args)
	{
		$post_type = strtolower($args[0]);
		$post_type_class = ucwords(str_replace('-', '', $post_type));
		$plugin_slug    = $assoc_args['plugin'];
		$plugin_name    = ucwords(str_replace('-', ' ', $plugin_slug));
		$plugin_namespace = str_replace(' ', '', $plugin_name);
		$plugin_dir = WP_PLUGIN_DIR . "/$plugin_slug";

		$data = [
			'post_type' => $post_type,
			'post_type_class' => $post_type_class,
			'plugin_namespace' => $plugin_namespace
		];

		$force = \WP_CLI\Utils\get_flag_value($assoc_args, 'force');

		if (!is_dir("$plugin_dir/$plugin_namespace/Features/PostTypes")) {
			WP_CLI::success("Création du Dossier PosTypes");
			wp_mkdir_p("$plugin_dir/$plugin_namespace/Features/PostTypes");
		}

		if (!is_file("$plugin_dir/$plugin_namespace/Features/PostTypes/{$post_type_class}PostType.php")) {
			// AJout du fichier pour le post type
			WP_CLI::success("Création du fichier {$post_type_class}PostType.php");

			$parent = new parent();
			$parent->create_files(array(
				"$plugin_dir/$plugin_namespace/Features/PostTypes/{$post_type_class}PostType.php" => self::mustache_render('plugin/features-posttype.mustache', $data),
			), $force);

			// Ajout du use du namespace
			self::insert_into_file(
				"$plugin_dir/config/features.php",
				"<?php",
				"use $plugin_namespace\\Features\\PostTypes\\{$post_type_class}PostType;"
			);

			// Ajout dans le fichier config/features.php
			self::insert_into_file(
				"$plugin_dir/config/features.php",
				"### POST TYPES ###",
				"	['init',[{$post_type_class}PostType::class,'register']],"
			);


			WP_CLI::success("Le post type a bien été créé");
		} else {
			WP_CLI::warning("Le fichier {$post_type_class}PostType.php existe déjà");
		}
	}
}
