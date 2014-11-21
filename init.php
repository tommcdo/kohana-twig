<?php defined('SYSPATH') or die('No direct script access.');

define('TWIGPATH', __DIR__ . DIRECTORY_SEPARATOR);

// Make Twig_Autoloader class available for projects without composer
if ( ! class_exists('Twig_Autoloader'))
{
	require_once 'vendor/twig/lib/Twig/Autoloader.php';
}

Twig::init();
