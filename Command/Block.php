<?php

namespace Command;

class Block extends YakPress
{
	public static function create($args, $assoc_args, $dir_slug, $dir_path)
	{
		$block       = strtolower($args[0]);
		$block_class = ucwords(str_replace('-', '', $block));
		$dir_name      = ucwords(str_replace('-', ' ', $dir_slug));
		$dir_namespace = str_replace(' ', '', $dir_name);
		$dir_name_trigram = substr($dir_name, 0, 3);

		$data = [
			'block'            => $block,
			'block_class'      => $block_class,
			'dir_namespace'    => $dir_namespace,
			'dir_name'         => $dir_name,
			'dir_name_trigram' => $dir_name_trigram,
			'dir_slug'         => $dir_slug
		];

		$force = \WP_CLI\Utils\get_flag_value($assoc_args, 'force');

		if (!is_dir("$dir_path/$dir_namespace/Features/Blocks")) {
			\WP_CLI::success("Création du Dossier Blocks");
			wp_mkdir_p("$dir_path/$dir_namespace/Features/Blocks");
		}

		if (is_file("$dir_path/$dir_namespace/Features/Blocks/{$block_class}Block.php")) {
			\WP_CLI::warning("Le fichier {$block_class}Block.php existe déjà");
		} else {
			// AJout du fichier pour le post type
			\WP_CLI::success("Création du fichier {$block_class}Block.php");

			$parent = new parent();
			$parent->create_files(array(
				"$dir_path/$dir_namespace/Features/Blocks/{$block_class}Block.php" => self::mustache_render('commun/features-block.mustache', $data),
				"$dir_path/resources/src/blocks/{$block}.js" => self::mustache_render('commun/src-block.mustache', $data),
			), $force);

			// Création des fichiers js
			if (!is_file("$dir_path/resources/src/package.json")) {
				$parent->create_files(array(
					"$dir_path/resources/src/package.json" => self::mustache_render('commun/package.json', $data)
				), $force);

				shell_exec("npm i $dir_path/resources/src/");
			}
			shell_exec("cd $dir_path/resources/src/ && ./node_modules/.bin/wp-scripts build blocks/{$block}.js -o ../assets/blocks/{$block}.js");

			// Ajout du use du namespace
			self::insert_into_file(
				"$dir_path/config/blocks.php",
				"<?php",
				"use $dir_namespace\\Features\\Blocks\\{$block_class}Block;"
			);

			// Ajout dans le fichier config/features.php
			self::insert_into_file(
				"$dir_path/config/blocks.php",
				"### BLOCKS ###",
				"	['init', [{$block_class}Block::class,'register']],"
			);


			\WP_CLI::success("Le block a bien été créé");
		}
	}
}
