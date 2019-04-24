<?php

namespace Command;

class Provider extends YakPress
{
	public static function create($args, $assoc_args, $dir_slug, $dir_path)
	{
		$provider       = strtolower($args[0]);
		$provider_class = ucwords(str_replace('-', '', $provider));
		$dir_name       = ucwords(str_replace('-', ' ', $dir_slug));
		$dir_namespace  = str_replace(' ', '', $dir_name);

		$data = [
			'provider'       => $provider,
			'provider_class' => $provider_class,
			'dir_namespace'  => $dir_namespace
		];

		$force = \WP_CLI\Utils\get_flag_value($assoc_args, 'force');



		if (!is_file("$dir_path/$dir_namespace/Providers/{$provider_class}Provider.php")) {
			// AJout du fichier pour le post type

			$parent = new parent();
			$parent->create_files(array(
				"$dir_path/$dir_namespace/Providers/{$provider_class}Provider.php" => self::mustache_render('commun/providers-provider.mustache', $data),
			), $force);

			\WP_CLI::success("Création du fichier {$provider_class}Provider.php");

			// Ajout dans le fichier config/features.php
			self::insert_into_file(
				"$dir_path/config/providers.php",
				"return [",
				" \\$dir_namespace\\Providers\\{$provider_class}Provider::class,"
			);

			\WP_CLI::success("Le provider a bien été créé");
		} else {
			\WP_CLI::warning("Le fichier {$provider_class}Provider.php existe déjà");
		}
	}
}
