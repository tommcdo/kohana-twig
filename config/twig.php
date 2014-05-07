<?php defined('SYSPATH') or die('No direct script access.');

return array(

	/**
	 * Twig Loader options
	 */
	'loader' => array(
		'extension' => 'html',  // Extension for Twig files
		'path'      => 'twigs', // Path within cascading filesystem for Twig files

        /**
         * Enable caching of directories list
         */
        'cache' =>  (Kohana::$environment == Kohana::PRODUCTION),

        /**
         * Namespaces to add
         *
         *      'namespaces' => array(
         *          'templates' =>  'base/templates',
         *          'layouts'   =>  array('base/layouts', 'admin/layouts'),
         *      )
         */
        'namespaces'    =>  array(
            'layouts'   =>  'layouts',
            'templates' =>  'templates',
        ),
	),

	/**
	 * Twig Environment options
	 *
	 * http://twig.sensiolabs.org/doc/api.html#environment-options
	 */
	'environment' => array(
		'auto_reload'         => (Kohana::$environment == Kohana::DEVELOPMENT),
        'debug'               => (Kohana::$environment == Kohana::DEVELOPMENT),
        'autoescape'          => TRUE,
		'base_template_class' => 'Twig_Template',
		'cache'               => TWIGPATH.'cache',
		'charset'             => 'utf-8',
		'optimizations'       => -1,
		'strict_variables'    => FALSE,
	),

	/**
	 * Custom functions, filters and tests
	 *
	 *      'functions' => array(
	 *          'my_method' => array('MyClass', 'my_method'),
	 *      ),
	 */
	'functions' => array(),
	'filters' => array(),
        'tests' => array()

    /**
     * Twig extensions to register
     *
     *      'extensions' => array(
     *          'Twig_Extension_Debug',
     *          'MyProject_Twig_Extension'
     *      )
     */
    'extensions'    =>  array(),

);
