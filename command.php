<?php

if (!class_exists('WP_CLI')) {
	return;
}

require_once(__DIR__ . "/vendor/autoload.php");
WP_CLI::add_command('plugin:new', ["Command\YakPress", "plugin"]);
WP_CLI::add_command('plugin:posttype', ["Command\YakPress", "post_type"]);
WP_CLI::add_command('plugin:metabox', ["Command\YakPress", "metabox"]);
WP_CLI::add_command('plugin:widget', ["Command\YakPress", "widget"]);
WP_CLI::add_command('plugin:taxonomy', ["Command\YakPress", "taxonomy"]);
WP_CLI::add_command('plugin:section', ["Command\YakPress", "section"]);
WP_CLI::add_command('plugin:page', ["Command\YakPress", "page"]);
WP_CLI::add_command('plugin:model', ["Command\YakPress", "model"]);
WP_CLI::add_command('plugin:controller', ["Command\YakPress", "controller"]);
WP_CLI::add_command('plugin:provider', ["Command\YakPress", "provider"]);
WP_CLI::add_command('plugin:middleware', ["Command\YakPress", "middleware"]);
WP_CLI::add_command('plugin:migration', ["Command\YakPress", "migration"]);
WP_CLI::add_command('morphing', ["Command\YakPress", "morphing"]);
WP_CLI::add_command('add:twig', ["Command\YakPress", "twig"]);



WP_CLI::add_command("bonjour", ["Command\Yakpress", "miou"]);
