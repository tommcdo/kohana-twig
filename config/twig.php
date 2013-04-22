<?php defined('SYSPATH') or die('No direct script access.');

return array(

	'loader' => array(
		'path' => 'twigs',
		'extension' => 'html',
	),
	'environment' => array(
		'cache' => TWIGPATH.'cache',
		'auto_reload' => (Kohana::$environment == Kohana::DEVELOPMENT),
	),

);
