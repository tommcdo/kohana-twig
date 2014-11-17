<?php defined('SYSPATH') or die('No direct script access.');

define('TWIGPATH', __DIR__ . DIRECTORY_SEPARATOR);

// Enable the Twig autoloader for composer-less projects.
if ( ! class_exists('Twig_Autoloader'))
{
	require_once 'vendor/twig/lib/Twig/Autoloader.php';
}

Twig::init();
