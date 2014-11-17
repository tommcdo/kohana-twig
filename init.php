<?php defined('SYSPATH') or die('No direct script access.');

define('TWIGPATH', rtrim(dirname(__FILE__), DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR);

// make the Twig autoloader available for composer-less projects
if ( ! class_exists('Twig_Autoloader')) {
	require_once 'vendor/twig/lib/Twig/Autoloader.php';
}

Twig::init();
