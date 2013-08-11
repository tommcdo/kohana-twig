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
	 * Initialize the Twig module
	 */
	public static function init()
	{
		require_once TWIGPATH.'vendor/twig/lib/Twig/Autoloader.php';
		Twig_Autoloader::register();

		$path = Kohana::$config->load('twig.environment.cache');
		if ( ! is_writable($path) && ! mkdir($path) )
		{
			throw new Kohana_Exception('Directory :dir must be writable', array(
				':dir' => Debug::path($path),
			));
		}

		$extensions = Kohana::$config->load('twig.extensions');
		if ($extensions)
		{
			require_once TWIGPATH.'vendor/twig-extensions/lib/Twig/Extensions/Autoloader.php';
			Twig_Extensions_Autoloader::register();
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
		$environment = new Twig_Environment($loader, $config->get('environment'));

		// Register standard extensions
		$extensions = $config->get('extensions');
		if ($extensions && is_array($extensions))
		{
			foreach ($extensions as $extension)
			{
				$name = ucwords(strtolower($extension));
				$class = 'Twig_Extensions_Extension_'.$name;
				$environment->addExtension(new $class());
			}
		}

		return $environment;
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
		return static::environment()->render($this->_file, $this->_data);
	}

} // End Twig
