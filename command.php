<?php

if (!class_exists('WP_CLI')) {
	return;
}

WP_CLI::add_command('plugin:new', ["Command\YakPress", "plugin"]);
WP_CLI::add_command('plugin:posttype', ["Command\YakPress", "plugin_post_type"]);
WP_CLI::add_command('plugin:metabox', ["Command\YakPress", "plugin_metabox"]);
WP_CLI::add_command('plugin:widget', ["Command\YakPress", "plugin_widget"]);
WP_CLI::add_command('plugin:taxonomy', ["Command\YakPress", "plugin_taxonomy"]);
WP_CLI::add_command('plugin:section', ["Command\YakPress", "plugin_section"]);
WP_CLI::add_command('plugin:page', ["Command\YakPress", "plugin_page"]);
WP_CLI::add_command('plugin:model', ["Command\YakPress", "plugin_model"]);
WP_CLI::add_command('plugin:controller', ["Command\YakPress", "plugin_controller"]);
WP_CLI::add_command('plugin:provider', ["Command\YakPress", "plugin_provider"]);
WP_CLI::add_command('plugin:middleware', ["Command\YakPress", "plugin_middleware"]);
WP_CLI::add_command('plugin:migration', ["Command\YakPress", "plugin_migration"]);
WP_CLI::add_command('plugin:seed', ["Command\YakPress", "plugin_seed"]);

WP_CLI::add_command('theme:new', ["Command\YakPress", "theme"]);
WP_CLI::add_command('theme:posttype', ["Command\YakPress", "theme_post_type"]);
WP_CLI::add_command('theme:metabox', ["Command\YakPress", "theme_metabox"]);
WP_CLI::add_command('theme:widget', ["Command\YakPress", "theme_widget"]);
WP_CLI::add_command('theme:taxonomy', ["Command\YakPress", "theme_taxonomy"]);
WP_CLI::add_command('theme:section', ["Command\YakPress", "theme_section"]);
WP_CLI::add_command('theme:page', ["Command\YakPress", "theme_page"]);
WP_CLI::add_command('theme:model', ["Command\YakPress", "theme_model"]);
WP_CLI::add_command('theme:controller', ["Command\YakPress", "theme_controller"]);
WP_CLI::add_command('theme:provider', ["Command\YakPress", "theme_provider"]);
WP_CLI::add_command('theme:middleware', ["Command\YakPress", "theme_middleware"]);
WP_CLI::add_command('theme:seed', ["Command\YakPress", "theme_seed"]);
WP_CLI::add_command('theme:customizer', ["Command\YakPress", "theme_customizer"]);

WP_CLI::add_command('morphing', ["Command\YakPress", "morphing"]);
WP_CLI::add_command('add:twig', ["Command\YakPress", "twig"]);
