<?php

return [

	/**
	 * Twig Loader options
	 */
	'loader' => [
		'extension' => 'html',  // Extension for Twig files
		'path'      => 'twigs', // Path within cascading filesystem for Twig files
	],

	/**
	 * Twig Environment options
	 *
	 * http://twig.sensiolabs.org/doc/api.html#environment-options
	 */
	'environment' => [
		'auto_reload'         => (Kohana::$environment == Kohana::DEVELOPMENT),
		'autoescape'          => TRUE,
		'base_template_class' => 'Twig_Template',
		'cache'               => APPPATH.'cache/twig',
		'charset'             => 'utf-8',
		'optimizations'       => -1,
		'strict_variables'    => FALSE,
	],

	/**
	 * Custom functions, filters and tests
	 *
	 *     'functions' => [
	 *         'my_method' => ['MyClass', 'my_method'],
	 *     ],
	 */
	'functions' => [],
	'filters' => [],
	'tests' => []
];
