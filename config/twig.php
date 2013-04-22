<?php defined('SYSPATH') or die('No direct script access.');

return array(

	'loader' => array(
		'extension' => 'html',
		'path'      => 'twigs',
	),
	'environment' => array(
		'auto_reload'         => (Kohana::$environment == Kohana::DEVELOPMENT),
		'autoescape'          => TRUE,
		'base_template_class' => 'Twig_Template',
		'cache'               => TWIGPATH.'cache',
		'charset'             => 'utf-8',
		'optimizations'       => -1,
		'strict_variables'    => FALSE,
	),

);
