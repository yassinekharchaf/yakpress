<?php

class Metabox extends YakPress
{
	public static function create($args, $assoc_args)
	{
		$metabox = strtolower($args[0]);
		$metabox_class = ucwords(str_replace('-', '', $metabox));
		$plugin_name = $assoc_args['plugin'];
		$plugin_namespace = ucfirst($plugin_name);
		$plugin_dir = WP_PLUGIN_DIR . "/$plugin_name";

		$data = [
			'metabox' => $metabox,
			'metabox_class' => $metabox_class,
			'plugin_namespace' => $plugin_namespace
		];

		$force = \WP_CLI\Utils\get_flag_value($assoc_args, 'force');

		if (!is_dir("$plugin_dir/$plugin_namespace/Features/MetaBoxes")) {
			WP_CLI::success("Création du Dossier MetaBoxes");
			wp_mkdir_p("$plugin_dir/$plugin_namespace/Features/MetaBoxes");
		}

		if (!is_file("$plugin_dir/$plugin_namespace/Features/MetaBoxes/{$metabox_class}MetaBox.php")) {
			// AJout du fichier pour le post type
			WP_CLI::success("Création du fichier {$metabox_class}MetaBox.php");

			$parent = new parent();
			$parent->create_files(array(
				"$plugin_dir/$plugin_namespace/Features/MetaBoxes/{$metabox_class}MetaBox.php" => self::mustache_render('features-metabox.mustache', $data),
			), $force);



			WP_CLI::success("La metabox a bien été créé");
		} else {
			WP_CLI::warning("Le fichier {$metabox_class}MetaBox.php existe déjà");
		}
	}
}
