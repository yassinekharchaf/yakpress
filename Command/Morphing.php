<?php

namespace Command;

class Morphing extends YakPress
{

  public static function create($assoc_args)
  {
    $wp_content_name = $assoc_args['wp-content'];
    $plugins_name = $assoc_args['plugins'];
    $uploads_name = $assoc_args['uploads'];

    $config_file_content = <<<EOT
### WORPHING ###
// Change wp-content path
if (isset(\$_SERVER['DOCUMENT_ROOT'])) {
  define('WP_CONTENT_DIR', \$_SERVER['DOCUMENT_ROOT'] . '/$wp_content_name');
}
// Change wp-content url
if (isset(\$_SERVER['HTTP_HOST'])) {
  define('WP_CONTENT_URL', 'http://' . \$_SERVER['HTTP_HOST'] . '/$wp_content_name');
}
// Change plugins path
if (isset(\$_SERVER['DOCUMENT_ROOT'])) {
  define('WP_PLUGIN_DIR', \$_SERVER['DOCUMENT_ROOT'] . '/$wp_content_name/$plugins_name');
}
// Change plugins url
if (isset(\$_SERVER['HTTP_HOST'])) {
  define('WP_PLUGIN_URL', 'http://' . \$_SERVER['HTTP_HOST'] . '/$wp_content_name/$plugins_name');
}
// change uploads path
define('UPLOADS', '$wp_content_name/$uploads_name');

EOT;

    $wordpress_dir = ABSPATH;

    self::insert_into_file($wordpress_dir . 'wp-config.php', "That's all, stop editing!", $config_file_content, false);

    rename(ABSPATH . "wp-content/plugins", ABSPATH . "wp-content/$plugins_name");
    rename(ABSPATH . "wp-content/uploads", ABSPATH . "wp-content/$uploads_name");
    rename(ABSPATH . "wp-content", ABSPATH . $wp_content_name);

    \WP_CLI::success("Your wordpress application has just been morphed");
  }
}
