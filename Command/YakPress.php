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
    Section::create($args, $assoc_args);
  }

  /**
   * Ajout d'une page
   *
   * ## OPTIONS
   *
   * <page-name>
   * : Nom de la page
   *
   * --plugin=<plugin-name>
   * : Nom du plugin auquel rajouter le widget
   *
   * [--controller]
   * : Ajoute un controller associé
   *
   * [--model]
   * : Ajout un model associé
   *
   */
  public function page($args, $assoc_args)
  {
    Page::create($args, $assoc_args);
  }

  /**
   * Ajout d'un model
   *
   * ## OPTIONS
   *
   * <model-name>
   * : Nom du model
   *
   * --plugin=<plugin-name>
   * : Nom du plugin auquel rajouter le widget
   *
   * [--controller]
   * : Ajoute un controller associé
   *
   */

  public function model($args, $assoc_args)
  {
    Model::create($args, $assoc_args);
  }

  /**
   * Ajout d'un model
   *
   * ## OPTIONS
   *
   * <controller-name>
   * : Nom du model
   *
   * --plugin=<plugin-name>
   * : Nom du plugin auquel rajouter le widget
   *
   * [--model]
   * : Ajoute un controller associé
   *
   */
  public function controller($args, $assoc_args)
  {
    Controller::create($args, $assoc_args);
  }

  /**
   * Ajout d'un model
   *
   * ## OPTIONS
   *
   * <provider-name>
   * : Nom du provider
   *
   * --plugin=<plugin-name>
   * : Nom du plugin auquel rajouter le provider
   *
   */
  public function provider($args, $assoc_args)
  {
    Provider::create($args, $assoc_args);
  }

  /**
   * Ajout d'un middleware
   *
   * ## OPTIONS
   *
   * <middleware-name>
   * : Nom du middleware
   *
   * --plugin=<plugin-name>
   * : Nom du plugin auquel rajouter le middleware
   *
   */
  public function middleware($args, $assoc_args)
  {
    Middleware::create($args, $assoc_args);
  }

  /**
   * Ajout d'une migration
   *
   * ## OPTIONS
   *
   * <migration-name>
   * : Nom du middleware
   *
   * --plugin=<plugin-name>
   * : Nom du plugin auquel rajouter la migration
   *
   */
  public function migration($args, $assoc_args)
  {
    Migration::create($args, $assoc_args);
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
}
