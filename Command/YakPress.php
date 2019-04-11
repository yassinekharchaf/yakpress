<?php

class YakPress extends Scaffold_Command
{

	/**
	 * Create a plugin as a micro framework which will be prefilled with files
	 *
	 * ## OPTIONS
	 *
	 * <name>
	 * : The name of the plugin
	 *
	 */
	public function plugin($args, $assoc_args)
	{
		require_once('Plugin.php');

		Plugin::create($args, $assoc_args);
	}


	/**
	 * Ajout d'un post type pour wordpress
	 *
	 * ## OPTIONS
	 *
	 * <post-type-name>
	 * : Nom du type de contenu sous format slug donc sans accent ni espace
	 *
	 * --plugin=<plugin-name>
	 * : Nom du plugin auquel rajouter le post type
	 *
	 */
	public function post_type($args, $assoc_args)
	{
		require_once('PostType.php');
		PostType::create($args, $assoc_args);
	}


	/**
	 * Ajout d'une metabox
	 *
	 * ## OPTIONS
	 *
	 * <metabox-name>
	 * : Nom de la metabox
	 *
	 * --plugin=<plugin-name>
	 * : Nom du plugin auquel rajouter la metabox
	 *
	 */
	public function metabox($args, $assoc_args)
	{
		require_once('Metabox.php');
		Metabox::create($args, $assoc_args);
	}

	/**
	 * Ajout d'un widget
	 *
	 * ## OPTIONS
	 *
	 * <widget-name>
	 * : Nom du widget
	 *
	 * --plugin=<plugin-name>
	 * : Nom du plugin auquel rajouter le widget
	 *
	 */
	public function widget($args, $assoc_args)
	{
		require_once('Widget.php');
		Widget::create($args, $assoc_args);
	}

	/**
	 * Ajout d'une taxonomie
	 *
	 * ## OPTIONS
	 *
	 * <taxonomy-name>
	 * : Nom de la taxonomie
	 *
	 * --plugin=<plugin-name>
	 * : Nom du plugin auquel rajouter le widget
	 *
	 */
	public function taxonomy($args, $assoc_args)
	{
		require_once('Taxonomy.php');
		Taxonomy::create($args, $assoc_args);
	}


	/**
	 * Ajout d'une section
	 *
	 * ## OPTIONS
	 *
	 * <section-name>
	 * : Nom de la section
	 *
	 * --plugin=<plugin-name>
	 * : Nom du plugin auquel rajouter le widget
	 *
	 */
	public function section($args, $assoc_args)
	{
		require_once('Section.php');
		Section::create($args, $assoc_args);
	}


	/**
	 * Localizes the template path.
	 */
	public static function mustache_render($template, $data = array())
	{
		return \WP_CLI\Utils\mustache_render(dirname(dirname(__FILE__)) . '/templates/' . $template, $data);
	}

	public static function insert_into_file($file_path, $search, $text, $after = true)
	{
		$lines = file($file_path);
		$f = fopen($file_path, 'r+');
		$line_number = false;

		foreach ($lines as $key => $line) {
			if (strpos($line, $search) !== false && $after == false) {
				fwrite($f, $text . "\n");
				fwrite($f, $line);
			} elseif (strpos($line, $search) !== false && $after == true) {
				fwrite($f, $line);
				fwrite($f, $text . "\n");
			} else {
				fwrite($f, $line);
			}
		}
		fclose($f);
	}


	// while (list($key, $line) = each($lines) and !$line_number) {
	// 	$line_number = (strpos($line, $search) !== FALSE) ? $key + 1 : $line_number;
	// }


}
