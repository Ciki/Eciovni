<?php declare(strict_types=1);

umask(0);

require_once __DIR__ . '/../vendor/autoload.php';

if (!class_exists('Tester\Assert')) {
	echo "Install Nette Tester using `composer update --dev`\n";
	exit(1);
}

Tester\Environment::setup();
date_default_timezone_set('Europe/Prague');

define('TEMP_DIR', __DIR__ . '/temp/' . getmypid());

Tester\Helpers::purge(TEMP_DIR);
