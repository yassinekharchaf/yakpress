<?php

namespace Command;

class Seed extends YakPress
{
	public static function create($args, $assoc_args, $dir_slug, $dir_path)
	{
		$seed       = strtolower($args[0]);
		$seed_class = ucwords(str_replace('-', '', $seed) . 'Seed');
		$dir_name        = ucwords(str_replace('-', ' ', $dir_slug));
		$dir_namespace   = str_replace(' ', '', $dir_name);
		$force           = \WP_CLI\Utils\get_flag_value($assoc_args, 'force');

		$data = [
			'seed'       => $seed,
			'seed_class' => $seed_class,
			'dir_namespace'   => $dir_namespace,
		];


		// if (!is_dir("$dir_path/$dir_namespace/Database/Factory")) {
		//   \WP_CLI::success("Création du Dossier Factory");
		//   wp_mkdir_p("$dir_path/$dir_namespace/Database/Factory");
		// }
		if ($seed == "all") {
			shell_exec("wp eval '\\$dir_namespace\\Database\\Factory\\Factory::seed();'");
		} else {
			shell_exec("wp eval '\\$dir_namespace\\Database\\Factory\\Seeds\\$seed_class::seed();'");
		}
	}
}
