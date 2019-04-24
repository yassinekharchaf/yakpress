<?php

namespace Command;

class Migration extends YakPress
{
  public static function create($args, $assoc_args, $dir_slug, $dir_path)
  {
    $migration       = strtolower($args[0]);
    $migration_class = ucwords(str_replace('-', '', $migration));
    $dir_name        = ucwords(str_replace('-', ' ', $dir_slug));
    $dir_namespace   = str_replace(' ', '', $dir_name);
    $force           = \WP_CLI\Utils\get_flag_value($assoc_args, 'force');

    $data = [
      'migration'       => $migration,
      'migration_class' => $migration_class,
      'dir_namespace'   => $dir_namespace,
    ];


    if (!is_dir("$dir_path/$dir_namespace/Database/Migrations")) {
      \WP_CLI::success("Création du Dossier Migrations");
      wp_mkdir_p("$dir_path/$dir_namespace/Database/Migrations");
    }

    if (!is_file("$dir_path/$dir_namespace/Database/Migrations/{$migration_class}Migration.php")) {
      // AJout du fichier pour le post type
      \WP_CLI::success("Création du fichier {$migration_class}Migration.php");

      $parent = new parent();
      $parent->create_files(array(
        "$dir_path/$dir_namespace/Database/Migrations/{$migration_class}Table.php" => self::mustache_render('plugin/databases-migration.mustache', $data),
      ), $force);

      // Ajout du use du namespace
      self::insert_into_file(
        "$dir_path/{$dir_namespace}/Database/Database.php",
        "namespace",
        "\nuse $dir_namespace\\Database\\Migration\\{$migration_class}Table;"
      );

      // Ajout dans la méthode activation
      self::insert_into_file(
        "$dir_path/{$dir_namespace}/Database/Database.php",
        "### CREATE TABLE ###",
        "		{$migration_class}Table::up();\n"
      );
      // Ajout dans la méthode uninstall
      self::insert_into_file(
        "$dir_path/{$dir_namespace}/Database/Database.php",
        "### DROP TABLE ###",
        "		{$migration_class}Table::down();\n"
      );


      \WP_CLI::success("Le migration a bien été créé");
    } else {
      \WP_CLI::warning("Le fichier {$migration_class}Migration.php existe déjà");
    }
  }
}
