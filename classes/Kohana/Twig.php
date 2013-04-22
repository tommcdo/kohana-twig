<?php defined('SYSPATH') or die('No direct script access.');

class Kohana_Twig extends View {

	protected static $_environment = NULL;

	public static function init()
	{
		require_once TWIGPATH.'vendor/twig/lib/Twig/Autoloader.php';
		Twig_Autoloader::register();

		$path = Kohana::$config->load('twig.environment.cache');
		if ( ! is_writable($path))
		{
			throw new Kohana_Exception('Directory :dir must be writable', array(
				':dir' => Debug::path($path),
			));
		}
	}

	public static function factory($file = NULL, array $data = NULL)
	{
		return new Twig($file, $data);
	}

	protected static function environment()
	{
		if (static::$_environment === NULL)
		{
			$config = Kohana::$config->load('twig');
			$loader = new Twig_Loader_CFS($config->get('loader'));
			static::$_environment = new Twig_Environment($loader, $config->get('environment'));
		}
		return static::$_environment;
	}

	function set_filename($file)
	{
		$this->_file = $file;
		return $this;
	}

	public function render($file = NULL)
	{
		if ($file !== NULL)
		{
			$this->set_filename($file);
		}
		$template = static::environment()->loadTemplate($this->_file);
		return $template->render($this->_data);
	}

} // End Twig
