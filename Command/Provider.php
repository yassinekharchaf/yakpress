<?php

class Provider extends YakPress
{
	public static function create($args, $assoc_args)
	{
		$provider = strtolower($args[0]);
		$provider_class = ucwords(str_replace('-', '', $provider));
		$plugin_name = $assoc_args['plugin'];
		$plugin_namespace = ucfirst($plugin_name);
		$plugin_dir = WP_PLUGIN_DIR . "/$plugin_name";

		$data = [
			'provider' => $provider,
			'provider_class' => $provider_class,
			'plugin_namespace' => $plugin_namespace
		];

		$force = \WP_CLI\Utils\get_flag_value($assoc_args, 'force');



		if (!is_file("$plugin_dir/$plugin_namespace/Providers/{$provider_class}Provider.php")) {
			// AJout du fichier pour le post type
			WP_CLI::success("Création du fichier {$provider_class}Provider.php");

			$parent = new parent();
			$parent->create_files(array(
				"$plugin_dir/$plugin_namespace/Providers/{$provider_class}Provider.php" => self::mustache_render('providers-provider.mustache', $data),
			), $force);

			// Ajout dans le fichier config/features.php
			self::insert_into_file(
				"$plugin_dir/config/providers.php",
				"return [",
				" \\$plugin_namespace\\Providers\\{$provider_class}Provider::class;"
			);

			WP_CLI::success("Le provider a bien été créé");
		} else {
			WP_CLI::warning("Le fichier {$provider_class}Provider.php existe déjà");
		}
	}
}
