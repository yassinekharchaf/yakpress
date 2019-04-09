<?php

if (!class_exists('WP_CLI')) {
	return;
}

require_once(__DIR__ . '/Command/YakPress.php');



WP_CLI::add_command('yakpress', "YakPress");
