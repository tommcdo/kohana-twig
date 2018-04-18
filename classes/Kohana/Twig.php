<?php

/**
 * Twig view
 */
class Kohana_Twig extends View {

	/**
	 * Twig environment
	 */
	protected static $_environment = NULL;

	/**
	 * Initialize the cache directory
	 *
	 * @param   string  $path Path to the cache directory
	 * @return  boolean
	 */
	protected static function _init_cache($path)
	{
		if (mkdir($path, 0755, TRUE) AND chmod($path, 0755))
			return TRUE;

		return FALSE;
	}

	/**
	 * Initialize the Twig module
	 *
	 * @throws Kohana_Exception
	 * @return bool
	 */
	public static function init()
	{
		$path = Kohana::$config->load('twig.environment.cache');
		if ($path !== FALSE AND ! is_writable($path) AND ! self::_init_cache($path))
		{
			throw new Kohana_Exception('Directory :dir must exist and be writable', [
				':dir' => Debug::path($path),
			]);
		}
		return true;
	}

	/**
	 * Create a Twig view instance
	 *
	 * @param   string  $file  Name of Twig template
	 * @param   array   $data  Data to be passed to template
	 * @return  Twig    Twig view instance
	 */
	public static function factory($file = NULL, array $data = NULL)
	{
		return new Twig($file, $data);
	}

	/**
	 * Create a new Twig environment
	 *
	 * @return  Twig_Environment  Twig environment
	 */
	protected static function env()
	{
		$config = Kohana::$config->load('twig');
		$loader = new Twig_Loader_CFS($config->get('loader'));
		$env = new Twig_Environment($loader, $config->get('environment'));

		foreach ($config->get('functions') as $key => $value)
		{
			$function = new Twig_SimpleFunction($key, $value);
			$env->addFunction($function);
		}

		foreach ($config->get('filters') as $key => $value)
		{
			$filter = new Twig_SimpleFilter($key, $value);
			$env->addFilter($filter);
		}
                
		foreach ($config->get('tests') as $key => $value)
		{
			$test = new Twig_SimpleTest($key, $value);
			$env->addTest($test);
		}

		return $env;
	}

	/**
	 * Get the Twig environment (or create it on first call)
	 *
	 * @return  Twig_Environment  Twig environment
	 */
	protected static function environment()
	{
		if (static::$_environment === NULL)
		{
			static::$_environment = static::env();
		}
		return static::$_environment;
	}

	/**
	 * Set the filename for the Twig view
	 *
	 * @param   string  $file  Base name of template
	 * @return  Twig    This Twig instance
	 */
	function set_filename($file)
	{
		$this->_file = $file;
		return $this;
	}

	/**
	 * Render Twig template as string
	 *
	 * @param   string  $file  Base name of template
	 * @return  string  Rendered Twig template
	 */
	public function render($file = NULL)
	{
		if ($file !== NULL)
		{
			$this->set_filename($file);
		}

		// Bind global data to Twig environment.
		foreach (static::$_global_data as $key => $value)
		{
			static::environment()->addGlobal($key, $value);
		}

		return static::environment()->render($this->_file, $this->_data);
	}

} // End Twig
