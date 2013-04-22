<?php defined('SYSPATH') or die('No direct script access.');

return array(

	'path' => 'twigs',
	'extension' => 'html',
	'cache' => TWIGPATH.'cache',
	'auto_reload' => (Kohana::$environment == Kohana::DEVELOPMENT),

);
