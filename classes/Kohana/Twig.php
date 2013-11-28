<?php defined('SYSPATH') or die('No direct script access.');

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
	 */
	public static function init()
	{
		require_once TWIGPATH.'vendor/twig/lib/Twig/Autoloader.php';
		Twig_Autoloader::register();

		$path = Kohana::$config->load('twig.environment.cache');
		if ($path !== FALSE AND ! is_writable($path) AND ! self::_init_cache($path))
		{
			throw new Kohana_Exception('Directory :dir must exist and be writable', array(
				':dir' => Debug::path($path),
			));
		}
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

		foreach ($config->get('extensions') as $extension_class)
		{
            $extension = new $extension_class;
			$env->addExtension($extension);
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
     * @throws View_Exception
     */
    public function render($file = NULL)
	{
		if ($file !== NULL)
		{
			$this->set_filename($file);
		}

        if (empty($this->_file))
        {
            throw new Twig_Exception('You must set the file to use within your Twig view before rendering');
        }

        return static::capture($this->_file, $this->_data);
    }

    /**
     * Captures the output that is generated when a view is included.
     * The view data will be extracted to make local variables. This method
     * is static to prevent object scope resolution.
     *
     *     $output = Twig::capture($file, $data);
     *
     * @param   string  $kohana_view_filename   filename
     * @param   array   $kohana_view_data       variables
     * @return  string
     */
    protected static function capture($kohana_view_filename, array $kohana_view_data)
    {
        // Import the view variables to local namespace
        extract($kohana_view_data, EXTR_SKIP);

        if (View::$_global_data)
        {
            // Import the global view variables to local namespace
            extract(View::$_global_data, EXTR_SKIP | EXTR_REFS);
        }

        return static::environment()->render($kohana_view_filename, $kohana_view_data);
    }

} // End Twig
