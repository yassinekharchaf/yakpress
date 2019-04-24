<?php

namespace Command;

use Command\Controller;
use Command\Metabox;
use Command\Middleware;
use Command\Migration;
use Command\Model;
use Command\Morphing;
use Command\Page;
use Command\Plugin;
use Command\Theme;
use Command\PostType;
use Command\Provider;
use Command\Section;
use Command\Taxonomy;
use Command\Twig;
use Command\Widget;

class YakPress extends \Scaffold_Command
{

	/**
	 * Create a plugin as a micro framework which will be prefilled with files
	 *
	 * ## OPTIONS
	 *
	 * <name>
	 * : The name of the plugin
	 *
	 * [--nohelpers]
	 * : ne rajoute pas le fichier helpers.php
	 *
	 */
	public function plugin($args, $assoc_args)
	{
		// $subcommand = explode(':', $args[0]);

		// call_user_func(Plugin::class, "$subcommand[0]_$subcommand[1]");

		Plugin::create($args, $assoc_args);
	}

	/**
	 * Create a plugin as a micro framework which will be prefilled with files
	 *
	 * ## OPTIONS
	 *
	 * <name>
	 * : The name of the plugin
	 *
	 * [--nohelpers]
	 * : ne rajoute pas le fichier helpers.php
	 *
	 */
	public function theme($args, $assoc_args)
	{
		// $subcommand = explode(':', $args[0]);

		// call_user_func(Plugin::class, "$subcommand[0]_$subcommand[1]");

		Theme::create($args, $assoc_args);
	}


	/**
	 * Ajout d'un post type pour wordpress
	 *
	 * ## OPTIONS
	 *
	 * <post-type-name>
	 * : Nom du type de contenu sous format slug donc sans accent ni espace
	 *
	 * [--plugin=<plugin-name>]
	 * : Nom du plugin auquel rajouter le post type
	 *
	 */
	public function plugin_post_type($args, $assoc_args)
	{
		$dir_slug = self::get_slug($assoc_args, "plugin");
		$dir_path = WP_PLUGIN_DIR . "/$dir_slug";
		PostType::create($args, $assoc_args, $dir_slug, $dir_path);
	}

	/**
	 * Ajout d'un post type pour wordpress
	 *
	 * ## OPTIONS
	 *
	 * <post-type-name>
	 * : Nom du type de contenu sous format slug donc sans accent ni espace
	 *
	 * [--theme=<theme-name>]
	 * : Nom du theme auquel rajouter le post type
	 *
	 */
	public function theme_post_type($args, $assoc_args)
	{
		$dir_slug = self::get_slug($assoc_args, "theme");
		$dir_path = get_theme_root() . "/$dir_slug";
		PostType::create($args, $assoc_args, $dir_slug, $dir_path);
	}


	/**
	 * Ajout d'une metabox
	 *
	 * ## OPTIONS
	 *
	 * <metabox-name>
	 * : Nom de la metabox
	 *
	 * [--plugin=<plugin-name>]
	 * : Nom du plugin auquel rajouter la metabox
	 *
	 */
	public function plugin_metabox($args, $assoc_args)
	{
		$dir_slug = self::get_slug($assoc_args, "plugin");
		$dir_path = WP_PLUGIN_DIR . "/$dir_slug";
		Metabox::create($args, $assoc_args, $dir_slug, $dir_path);
	}

	/**
	 * Ajout d'une metabox
	 *
	 * ## OPTIONS
	 *
	 * <metabox-name>
	 * : Nom de la metabox
	 *
	 * [--theme=<theme-name>]
	 * : Nom du theme auquel rajouter la metabox
	 *
	 */
	public function theme_metabox($args, $assoc_args)
	{
		$dir_slug = self::get_slug($assoc_args, "theme");
		$dir_path = get_theme_root() . "/$dir_slug";
		Metabox::create($args, $assoc_args, $dir_slug, $dir_path);
	}

	/**
	 * Ajout d'un widget
	 *
	 * ## OPTIONS
	 *
	 * <widget-name>
	 * : Nom du widget
	 *
	 * [--plugin=<plugin-name>]
	 * : Nom du plugin auquel rajouter le widget
	 *
	 */
	public function plugin_widget($args, $assoc_args)
	{
		$dir_slug = self::get_slug($assoc_args, "plugin");
		$dir_path = WP_PLUGIN_DIR . "/$dir_slug";
		Widget::create($args, $assoc_args, $dir_slug, $dir_path);
	}

	/**
	 * Ajout d'un widget
	 *
	 * ## OPTIONS
	 *
	 * <widget-name>
	 * : Nom du widget
	 *
	 * [--theme=<theme-name>]
	 * : Nom du theme auquel rajouter le widget
	 *
	 */
	public function theme_widget($args, $assoc_args)
	{
		$dir_slug = self::get_slug($assoc_args, "theme");
		$dir_path = get_theme_root() . "/$dir_slug";
		Widget::create($args, $assoc_args, $dir_slug, $dir_path);
	}

	/**
	 * Ajout d'une taxonomie
	 *
	 * ## OPTIONS
	 *
	 * <taxonomy-name>
	 * : Nom de la taxonomie
	 *
	 * [--plugin=<plugin-name>]
	 * : Nom du plugin auquel rajouter le widget
	 *
	 */
	public function plugin_taxonomy($args, $assoc_args)
	{
		$dir_slug = self::get_slug($assoc_args, "plugin");
		$dir_path = WP_PLUGIN_DIR . "/$dir_slug";
		Taxonomy::create($args, $assoc_args, $dir_slug, $dir_path);
	}

	/**
	 * Ajout d'une taxonomie
	 *
	 * ## OPTIONS
	 *
	 * <taxonomy-name>
	 * : Nom de la taxonomie
	 *
	 * [--theme=<theme-name>]
	 * : Nom du theme auquel rajouter le widget
	 *
	 */
	public function theme_taxonomy($args, $assoc_args)
	{
		$dir_slug = self::get_slug($assoc_args, "theme");
		$dir_path = get_theme_root() . "/$dir_slug";
		Taxonomy::create($args, $assoc_args, $dir_slug, $dir_path);
	}


	/**
	 * Ajout d'une section
	 *
	 * ## OPTIONS
	 *
	 * <section-name>
	 * : Nom de la section
	 *
	 * [--plugin=<plugin-name>]
	 * : Nom du plugin auquel rajouter le widget
	 *
	 */
	public function plugin_section($args, $assoc_args)
	{
		$dir_slug = self::get_slug($assoc_args, "plugin");
		$dir_path = WP_PLUGIN_DIR . "/$dir_slug";
		Section::create($args, $assoc_args, $dir_slug, $dir_path);
	}

	/**
	 * Ajout d'une section
	 *
	 * ## OPTIONS
	 *
	 * <section-name>
	 * : Nom de la section
	 *
	 * [--theme=<theme-name>]
	 * : Nom du theme auquel rajouter le widget
	 *
	 */
	public function theme_section($args, $assoc_args)
	{
		$dir_slug = self::get_slug($assoc_args, "theme");
		$dir_path = get_theme_root() . "/$dir_slug";
		Section::create($args, $assoc_args, $dir_slug, $dir_path);
	}

	/**
	 * Ajout d'une page
	 *
	 * ## OPTIONS
	 *
	 * <page-name>
	 * : Nom de la page
	 *
	 * [--plugin=<plugin-name>]
	 * : Nom du plugin auquel rajouter le widget
	 *
	 * [--controller]
	 * : Ajoute un controller associé
	 *
	 * [--model]
	 * : Ajout un model associé
	 *
	 */
	public function plugin_page($args, $assoc_args)
	{
		$dir_slug = self::get_slug($assoc_args, "plugin");
		$dir_path = WP_PLUGIN_DIR . "/$dir_slug";
		Page::create($args, $assoc_args, $dir_slug, $dir_path);
	}

	/**
	 * Ajout d'une page
	 *
	 * ## OPTIONS
	 *
	 * <page-name>
	 * : Nom de la page
	 *
	 * [--theme=<theme-name>]
	 * : Nom du theme auquel rajouter le widget
	 *
	 * [--controller]
	 * : Ajoute un controller associé
	 *
	 * [--model]
	 * : Ajout un model associé
	 *
	 */
	public function theme_page($args, $assoc_args)
	{
		$dir_slug = self::get_slug($assoc_args, "theme");
		$dir_path = get_theme_root() . "/$dir_slug";
		Page::create($args, $assoc_args, $dir_slug, $dir_path);
	}

	/**
	 * Ajout d'un model
	 *
	 * ## OPTIONS
	 *
	 * <model-name>
	 * : Nom du model
	 *
	 * [--plugin=<plugin-name>]
	 * : Nom du plugin auquel rajouter le widget
	 *
	 * [--controller]
	 * : Ajoute un controller associé
	 *
	 */

	public function plugin_model($args, $assoc_args)
	{
		$dir_slug = self::get_slug($assoc_args, "plugin");
		$dir_path = WP_PLUGIN_DIR . "/$dir_slug";
		Model::create($args, $assoc_args, $dir_slug, $dir_path);
	}

	/**
	 * Ajout d'un model
	 *
	 * ## OPTIONS
	 *
	 * <model-name>
	 * : Nom du model
	 *
	 * [--theme=<theme-name>]
	 * : Nom du theme auquel rajouter le widget
	 *
	 * [--controller]
	 * : Ajoute un controller associé
	 *
	 */

	public function theme_model($args, $assoc_args)
	{
		$dir_slug = self::get_slug($assoc_args, "theme");
		$dir_path = get_theme_root() . "/$dir_slug";
		Model::create($args, $assoc_args, $dir_slug, $dir_path);
	}

	/**
	 * Ajout d'un controller
	 *
	 * ## OPTIONS
	 *
	 * <controller-name>
	 * : Nom du controller
	 *
	 * [--plugin=<plugin-name>]
	 * : Nom du plugin auquel rajouter le widget
	 *
	 * [--model]
	 * : Ajoute un controller associé
	 *
	 * [--resource]
	 * : creé des méthodes resource (index, show, edit, update, delete)
	 *
	 */
	public function plugin_controller($args, $assoc_args)
	{
		$dir_slug = self::get_slug($assoc_args, "plugin");
		$dir_path = WP_PLUGIN_DIR . "/$dir_slug";
		Controller::create($args, $assoc_args, $dir_slug, $dir_path);
	}

	/**
	 * Create a controller for a theme
	 *
	 * # OPTIONS
	 *
	 * <controller-name>
	 * : Nom du controller
	 *
	 * [--theme=<theme-name>]
	 * : Nom du theme auquel rajouter le widget
	 *
	 * [--model]
	 * : Ajoute un controller associé
	 *
	 * [--resource]
	 * : creé des méthodes resource (index, show, edit, update, delete)
	 */
	public function theme_controller($args, $assoc_args)
	{
		$dir_slug = self::get_slug($assoc_args, "theme");
		$dir_path = get_theme_root() . "/$dir_slug";
		Controller::create($args, $assoc_args, $dir_slug, $dir_path);
	}

	/**
	 * Ajout d'un provider
	 *
	 * ## OPTIONS
	 *
	 * <provider-name>
	 * : Nom du provider
	 *
	 * [--plugin=<plugin-name>]
	 * : Nom du plugin auquel rajouter le provider
	 *
	 */
	public function plugin_provider($args, $assoc_args)
	{
		$dir_slug = self::get_slug($assoc_args, "plugin");
		$dir_path = WP_PLUGIN_DIR . "/$dir_slug";
		Provider::create($args, $assoc_args, $dir_slug, $dir_path);
	}

	/**
	 * Ajout d'un provider
	 *
	 * ## OPTIONS
	 *
	 * <provider-name>
	 * : Nom du provider
	 *
	 * [--theme=<theme-name>]
	 * : Nom du theme auquel rajouter le provider
	 *
	 */
	public function theme_provider($args, $assoc_args)
	{
		$dir_slug = self::get_slug($assoc_args, "theme");
		$dir_path = get_theme_root() . "/$dir_slug";
		Provider::create($args, $assoc_args, $dir_slug, $dir_path);
	}

	/**
	 * Ajout d'un middleware
	 *
	 * ## OPTIONS
	 *
	 * <middleware-name>
	 * : Nom du middleware
	 *
	 * [--plugin=<plugin-name>]
	 * : Nom du plugin auquel rajouter le middleware
	 *
	 */
	public function plugin_middleware($args, $assoc_args)
	{
		$dir_slug = self::get_slug($assoc_args, "plugin");
		$dir_path = WP_PLUGIN_DIR . "/$dir_slug";
		Middleware::create($args, $assoc_args, $dir_slug, $dir_path);
	}

	/**
	 * Ajout d'un middleware
	 *
	 * ## OPTIONS
	 *
	 * <middleware-name>
	 * : Nom du middleware
	 *
	 * [--theme=<theme-name>]
	 * : Nom du theme auquel rajouter le middleware
	 *
	 */
	public function theme_middleware($args, $assoc_args)
	{
		$dir_slug = self::get_slug($assoc_args, "theme");
		$dir_path = get_theme_root() . "/$dir_slug";
		Middleware::create($args, $assoc_args, $dir_slug, $dir_path);
	}

	/**
	 * Ajout d'une migration
	 *
	 * ## OPTIONS
	 *
	 * <migration-name>
	 * : Nom du middleware
	 *
	 * [--plugin=<plugin-name>]
	 * : Nom du plugin auquel rajouter la migration
	 *
	 */
	public function plugin_migration($args, $assoc_args)
	{
		$dir_slug = self::get_slug($assoc_args, "plugin");
		$dir_path = WP_PLUGIN_DIR . "/$dir_slug";
		Migration::create($args, $assoc_args, $dir_slug, $dir_path);
	}

	/**
	 * Change de structure of wordpress so it tempt people to hack it
	 *
	 * ## Options
	 *
	 * --wp-content=<new-folder-name>
	 * : The new name of the folder wp-content
	 *
	 * --plugins=<new-folder-name>
	 * : The new name of the folder plugins
	 *
	 * --uploads=<new-folder-name>
	 * : The new name of the folder uploads
	 *
	 */
	public function morphing($args, $assoc_args)
	{
		Morphing::create($assoc_args);
	}

	/**
	 * Change de structure of wordpress so it tempt people to hack it
	 */
	public function twig($args, $assoc_args)
	{
		Twig::create($args, $assoc_args);
	}



	###########################

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

	public static function get_slug($assoc_args, $feature)
	{
		$main_root = "";
		if ($feature == 'plugin') {
			if (isset($assoc_args['plugin'])) {
				return $assoc_args['plugin'];
			}
			$main_root = WP_PLUGIN_DIR;
		}
		if ($feature == 'theme') {
			if (isset($assoc_args['theme'])) {
				return $assoc_args['theme'];
			}
			$main_root = get_theme_root();
		}
		$current_dir = shell_exec("pwd");
		$current_dir = str_replace("\n", "", $current_dir);
		$in_plugin = strpos($current_dir, $main_root);

		if ($in_plugin !== false) {
			$current_dir = substr($current_dir, strlen($main_root) + 1);
			if (strlen($current_dir) > 0 && strpos($current_dir, "/") == false) {
				return $current_dir;
			}
		} else {
			\WP_CLI::error("You are not in a $feature, please give a specific $feature with --$feature=$feature-name or cd to the root of the $feature you work in.");
			\WP_CLI::halt();
		}
	}
}
