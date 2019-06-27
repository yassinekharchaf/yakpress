<?php

namespace Command;

class PostType extends YakPress
{
	public static function create($args, $assoc_args, $dir_slug, $dir_path)
	{
		$post_type       = strtolower($args[0]);
		$post_type_class = ucwords(str_replace('-', '', $post_type));
		$dir_name        = ucwords(str_replace('-', ' ', $dir_slug));
		$dir_namespace   = str_replace(' ', '', $dir_name);

		$data = [
			'post_type'       => $post_type,
			'post_type_class' => $post_type_class,
			'dir_namespace'   => $dir_namespace
		];

		$force = \WP_CLI\Utils\get_flag_value($assoc_args, 'force');

		if (!is_dir("$dir_path/$dir_namespace/Features/PostTypes")) {
			\WP_CLI::success("Création du Dossier PosTypes");
			wp_mkdir_p("$dir_path/$dir_namespace/Features/PostTypes");
		}

		if (!is_file("$dir_path/$dir_namespace/Features/PostTypes/{$post_type_class}PostType.php")) {
			// AJout du fichier pour le post type
			\WP_CLI::success("Création du fichier {$post_type_class}PostType.php");

			$parent = new parent();
			$parent->create_files(array(
				"$dir_path/$dir_namespace/Features/PostTypes/{$post_type_class}PostType.php" => self::mustache_render('commun/features-posttype.mustache', $data),
			), $force);

			// Ajout du use du namespace
			self::insert_into_file(
				"$dir_path/config/features.php",
				"<?php",
				"use $dir_namespace\\Features\\PostTypes\\{$post_type_class}PostType;"
			);

			// Ajout dans le fichier config/features.php
			self::insert_into_file(
				"$dir_path/config/features.php",
				"### POST TYPES ###",
				"	['init',[{$post_type_class}PostType::class,'register']],"
			);


            shell_exec("wp rewrite flush");
			\WP_CLI::success("Le post type a bien été créé");
		} else {
			\WP_CLI::warning("Le fichier {$post_type_class}PostType.php existe déjà");
		}
	}
}
