<?php

if (!class_exists('WP_CLI')) {
	return;
}

require_once(__DIR__ . "/vendor/autoload.php");
WP_CLI::add_command('make:plugin', ["Command\YakPress", "plugin"]);
WP_CLI::add_command('make:posttype', ["Command\YakPress", "post_type"]);
WP_CLI::add_command('make:metabox', ["Command\YakPress", "metabox"]);
WP_CLI::add_command('make:widget', ["Command\YakPress", "widget"]);
WP_CLI::add_command('make:taxonomy', ["Command\YakPress", "taxonomy"]);
WP_CLI::add_command('make:section', ["Command\YakPress", "section"]);
WP_CLI::add_command('make:page', ["Command\YakPress", "page"]);
WP_CLI::add_command('make:model', ["Command\YakPress", "model"]);
WP_CLI::add_command('make:controller', ["Command\YakPress", "controller"]);
WP_CLI::add_command('make:provider', ["Command\YakPress", "provider"]);
WP_CLI::add_command('make:middleware', ["Command\YakPress", "middleware"]);
WP_CLI::add_command('make:migration', ["Command\YakPress", "migration"]);
WP_CLI::add_command('morphing', ["Command\YakPress", "morphing"]);
WP_CLI::add_command('add:twig', ["Command\YakPress", "twig"]);
